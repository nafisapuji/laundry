<?php
session_start();
include '../koneksi.php';
include 'header.php';

// CEK LOGIN USER
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login" || $_SESSION['user_status'] != "user") {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

// Tangkap kendaraan_id dari URL
$kendaraan_id = $_GET['id'] ?? '';
$user_id = $_SESSION['user_id'];

if ($kendaraan_id == '') {
    echo "<script>alert('Kendaraan tidak ditemukan'); window.location='kendaraan.php';</script>";
    exit();
}

// Ambil data kendaraan
$kendaraan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kendaraan WHERE kendaraan_id='$kendaraan_id'"));

if (!$kendaraan) {
    echo "<script>alert('Kendaraan tidak ditemukan'); window.location='kendaraan.php';</script>";
    exit();
}

// Cek status kendaraan
if ($kendaraan['kendaraan_status'] != 'Tersedia') {
    echo "<script>alert('Kendaraan ini sedang tidak tersedia'); window.location='kendaraan.php';</script>";
    exit();
}

// Proses peminjaman jika form dikirim
if (isset($_POST['pinjam'])) {
    $tgl_pinjam = date('Y-m-d');
    $tgl_kembali = $_POST['tgl_kembali'];

    if ($tgl_kembali <= $tgl_pinjam) {
        echo "<script>alert('Tanggal kembali harus lebih dari hari ini'); window.history.back();</script>";
        exit();
    }

    $jumlah_hari = (strtotime($tgl_kembali) - strtotime($tgl_pinjam)) / (60*60*24) + 1;
    $total_biaya = $jumlah_hari * $kendaraan['kendaraan_harga_perhari'];

    $insert = mysqli_query($conn, "
        INSERT INTO pinjam (kendaraan_id, user_id, tgl_pinjam, tgl_kembali, pinjam_status)
        VALUES ('$kendaraan_id', '$user_id', '$tgl_pinjam', '$tgl_kembali', 'Dipinjam')
    ");

    $update = mysqli_query($conn, "
        UPDATE kendaraan SET kendaraan_status='Dipinjam' WHERE kendaraan_id='$kendaraan_id'
    ");

    if ($insert && $update) {
        echo "<script>alert('Berhasil meminjam! Total biaya: Rp ".number_format($total_biaya,0,',','.')."'); window.location='pinjam.php';</script>";
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan, silakan coba lagi'); window.location='kendaraan.php';</script>";
        exit();
    }
}
?>

<div class="container mt-5">
    <div class="card shadow-lg rounded-4">
        <div class="row g-0">
            <!-- Kolom Kiri: Info Kendaraan -->
            <div class="col-md-6 bg-light p-4 d-flex flex-column justify-content-center">
                <h3 class="fw-bold text-primary"><?= $kendaraan['kendaraan_nama']; ?></h3>
                <p class="text-muted mb-2"><strong>Tipe:</strong> <?= $kendaraan['kendaraan_tipe']; ?></p>
                <p class="mb-2"><strong>Harga per Hari:</strong> <span class="text-success">Rp <?= number_format($kendaraan['kendaraan_harga_perhari'],0,',','.'); ?></span></p>
                <p class="mb-4"><strong>Status:</strong> <span class="<?= $kendaraan['kendaraan_status']=='Tersedia' ? 'text-success' : 'text-danger'; ?>"><?= $kendaraan['kendaraan_status']; ?></span></p>

               
            </div>

            <!-- Kolom Kanan: Form Peminjaman -->
            <div class="col-md-6 p-4">
                <h4 class="fw-bold mb-3 text-center text-primary"><i class="bi bi-check-circle"></i> Pinjam Kendaraan</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label for="tgl_kembali" class="form-label fw-semibold">Tanggal Kembali</label>
                        <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control" required min="<?= date('Y-m-d'); ?>">
                    </div>

                    <div class="mb-3 text-center">
                        <p class="fw-bold">Total Biaya: <span class="text-success" id="totalBiaya">0</span></p>
                    </div>

                    <button type="submit" name="pinjam" class="btn btn-primary w-100 rounded-pill fw-bold">
                        <i class="bi bi-check-circle"></i> Pinjam Sekarang
                    </button>
                </form>

                <a href="kendaraan.php" class="btn btn-outline-secondary w-100 rounded-pill mt-3 fw-semibold text-dark">
                    <i class="bi bi-arrow-left"></i> Kembali ke Kendaraan
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Hitung total biaya otomatis
const hargaPerHari = <?= $kendaraan['kendaraan_harga_perhari']; ?>;
const tglKembali = document.getElementById('tgl_kembali');
const totalBiayaEl = document.getElementById('totalBiaya');

tglKembali.addEventListener('change', () => {
    const today = new Date();
    const kembali = new Date(tglKembali.value);

    if (kembali <= today) {
        totalBiayaEl.textContent = '0';
        return;
    }

    const diffTime = Math.abs(kembali - today);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
    const total = diffDays * hargaPerHari;

    totalBiayaEl.textContent = total.toLocaleString('id-ID');
});
</script>
