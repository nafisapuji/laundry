<?php
session_start();

// CEK LOGIN
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login" || $_SESSION['user_status'] != "user") {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

include '../koneksi.php';
include 'header.php';

// Ambil ID user
$user_id = $_SESSION['user_id'];

// Statistik
$jml_pinjam = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM pinjam WHERE user_id='$user_id' AND pinjam_status='Dipinjam'"
))['total'];

$jml_kembali = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM pinjam WHERE user_id='$user_id' AND pinjam_status='Kembali'"
))['total'];

$jml_kendaraan_tersedia = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM kendaraan"
))['total'];
?>

<!-- CONTENT WRAPPER -->
<div class="container mt-4">

    <!-- JUDUL -->
    <div class="text-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-person-badge"></i> Halo, <?= $_SESSION['user_nama']; ?> 👋
        </h2>
        <h4 class="text-secondary">Dashboard User</h4>
    </div>

    <!-- STATISTIK -->
    <div class="row justify-content-center">

        <!-- Kendaraan Tersedia -->
        <div class="col-md-4 mb-3">
            <div class="card shadow rounded-4 border-0" style="background: #e0f2fe;">
                <div class="card-body text-center">
                    <h5 class="fw-bold text-primary">
                        <i class="bi bi-car-front-fill"></i> Kendaraan Tersedia
                    </h5>
                    <h2 class="fw-bold"><?= $jml_kendaraan_tersedia; ?></h2>
                    <a href="kendaraan.php" class="btn btn-primary mt-2 w-100 rounded-pill">
                        <i class="bi bi-eye-fill"></i> Lihat Kendaraan
                    </a>
                </div>
            </div>
        </div>

        <!-- Sedang Dipinjam -->
        <div class="col-md-4 mb-3">
            <div class="card shadow rounded-4 border-0" style="background: #fff7cd;">
                <div class="card-body text-center">
                    <h5 class="fw-bold text-warning">
                        <i class="bi bi-hourglass-split"></i> Sedang Dipinjam
                    </h5>
                    <h2 class="fw-bold"><?= $jml_pinjam; ?></h2>
                    <a href="pinjam.php" class="btn btn-warning mt-2 w-100 rounded-pill text-dark">
                        <i class="bi bi-clock-history"></i> Lihat Pinjaman
                    </a>
                </div>
            </div>
        </div>

        <!-- Sudah Dikembalikan -->
        <div class="col-md-4 mb-3">
            <div class="card shadow rounded-4 border-0" style="background: #dcfce7;">
                <div class="card-body text-center">
                    <h5 class="fw-bold text-success">
                        <i class="bi bi-check-circle-fill"></i> Sudah Dikembalikan
                    </h5>
                    <h2 class="fw-bold"><?= $jml_kembali; ?></h2>
                    <a href="pinjam.php" class="btn btn-success mt-2 w-100 rounded-pill">
                        <i class="bi bi-list-check"></i> Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- RIWAYAT -->
    <div class="mt-5">
        <h4 class="fw-bold"><i class="bi bi-clock-history"></i> Riwayat Peminjaman Terbaru</h4>

        <table class="table table-striped mt-3 shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Kendaraan</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $query = mysqli_query($conn, "
                    SELECT p.*, k.kendaraan_nama 
                    FROM pinjam p
                    JOIN kendaraan k ON p.kendaraan_id = k.kendaraan_id
                    WHERE p.user_id='$user_id'
                    ORDER BY p.pinjam_id DESC LIMIT 5
                ");

                while ($t = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?= $t['pinjam_id']; ?></td>
                    <td><?= $t['kendaraan_nama']; ?></td>
                    <td><?= $t['tgl_pinjam']; ?></td>
                    <td><?= $t['tgl_kembali']; ?></td>
                    <td><?= $t['pinjam_status']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
