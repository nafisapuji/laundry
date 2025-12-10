<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../koneksi.php';
include 'header.php';

// CEK LOGIN ADMIN
if(!isset($_SESSION['status']) || $_SESSION['status']!='login' || $_SESSION['user_status']!='admin'){
    header("Location: index.php");
    exit();
}

// Ambil kendaraan_id dari URL
$kendaraan_id = $_GET['id'] ?? '';

if($kendaraan_id == ''){
    echo "<script>alert('Kendaraan tidak ditemukan'); window.location='kendaraan.php';</script>";
    exit();
}

// Ambil data kendaraan
$kendaraan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kendaraan WHERE kendaraan_id='$kendaraan_id'"));

if(!$kendaraan){
    echo "<script>alert('Kendaraan tidak ditemukan'); window.location='kendaraan.php';</script>";
    exit();
}
?>

<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-pencil-square"></i> Edit Kendaraan</h2>

    <div class="card shadow-sm p-4 rounded-4">
        <form method="POST" action="kendaraan_aksi.php?aksi=edit&id=<?= $kendaraan['kendaraan_id']; ?>">
            <div class="mb-3">
                <label for="kendaraan_nama" class="form-label">Nama Kendaraan</label>
                <input type="text" name="kendaraan_nama" id="kendaraan_nama" class="form-control" value="<?= $kendaraan['kendaraan_nama']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="kendaraan_tipe" class="form-label">Tipe Kendaraan</label>
                <input type="text" name="kendaraan_tipe" id="kendaraan_tipe" class="form-control" value="<?= $kendaraan['kendaraan_tipe']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="kendaraan_harga_perhari" class="form-label">Harga per Hari (Rp)</label>
                <input type="number" name="kendaraan_harga_perhari" id="kendaraan_harga_perhari" class="form-control" value="<?= $kendaraan['kendaraan_harga_perhari']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="kendaraan_status" class="form-label">Status Kendaraan</label>
                <select name="kendaraan_status" id="kendaraan_status" class="form-select" required>
                    <option value="Tersedia" <?= $kendaraan['kendaraan_status']=='Tersedia'?'selected':''; ?>>Tersedia</option>
                    <option value="Dipinjam" <?= $kendaraan['kendaraan_status']=='Dipinjam'?'selected':''; ?>>Dipinjam</option>
                </select>
            </div>

            <button type="submit" name="update" class="btn btn-primary w-100 rounded-pill">
                <i class="bi bi-save"></i> Simpan Perubahan
            </button>
        </form>

        <a href="kendaraan.php" class="btn btn-secondary w-100 rounded-pill mt-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
