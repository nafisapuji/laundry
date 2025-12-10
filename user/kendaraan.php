<?php
session_start();

// CEK LOGIN USER
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login" || $_SESSION['user_status'] != "user") {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

include '../koneksi.php';
include 'header.php';
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-4"><i class="bi bi-car-front-fill"></i> Kendaraan Tersedia</h2>

    <div class="row">
        <?php
        // Ambil kendaraan yang STATUS nya Tersedia
        $query = mysqli_query($conn, "SELECT * FROM kendaraan WHERE kendaraan_status='Tersedia' ORDER BY kendaraan_id ASC");

        if(mysqli_num_rows($query) == 0){
            echo '<p class="text-center fw-bold">Maaf, saat ini tidak ada kendaraan yang tersedia.</p>';
        }

        while ($k = mysqli_fetch_assoc($query)) {
        ?>
        <div class="col-md-4 mb-3">
            <div class="card shadow bg-success text-white border-0 rounded-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold"><?= $k['kendaraan_nama']; ?></h5>
                    <p class="card-text mb-1"><strong>Tipe:</strong> <?= $k['kendaraan_tipe']; ?></p>
                    <p class="card-text mb-1"><strong>Harga per Hari:</strong> Rp <?= number_format($k['kendaraan_harga_perhari'], 0, ',', '.'); ?></p>
                    <p class="card-text mb-1"><strong>Status:</strong> <?= $k['kendaraan_status']; ?></p>

                   
                    <a href="kendaraan_aksi.php?id=<?= $k['kendaraan_id']; ?>" class="btn btn-light w-100 rounded-pill mt-2">
                        <i class="bi bi-check-circle"></i> Pinjam Sekarang
                    </a>

                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <a href="index.php" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
</div>
