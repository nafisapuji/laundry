<?php
session_start();

// CEK LOGIN ADMIN
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login" || $_SESSION['user_status'] != "admin") {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

include '../koneksi.php';
include 'header.php';

// Statistik Admin
$total_user = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM user WHERE user_status='user'"
))['total'];

$total_kendaraan = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM kendaraan"
))['total'];

$total_pinjam_aktif = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM pinjam WHERE pinjam_status='Dipinjam'"
))['total'];

$total_pinjam_selesai = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM pinjam WHERE pinjam_status='Kembali'"
))['total'];

?>

<!-- CONTENT -->
<div class="container mt-4">

    <!-- Judul -->
    <div class="text-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-speedometer2"></i> Dashboard Admin</h2>
        <h5 class="text-secondary">Selamat datang, <?= $_SESSION['user_nama']; ?> 👋</h5>
    </div>

    <!-- STATISTIK -->
    <div class="row justify-content-center">

        <!-- Total User -->
        <div class="col-md-3 mb-3">
            <div class="card shadow rounded-4 border-0" style="background:#e0f2fe;">
                <div class="card-body text-center">
                    <h5 class="fw-bold text-primary"><i class="bi bi-people-fill"></i> Total User</h5>
                    <h2 class="fw-bold"><?= $total_user; ?></h2>
                    <a href="user.php" class="btn btn-primary w-100 mt-2 rounded-pill">
                        Kelola User
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Kendaraan -->
        <div class="col-md-3 mb-3">
            <div class="card shadow rounded-4 border-0" style="background:#dcfce7;">
                <div class="card-body text-center">
                    <h5 class="fw-bold text-success"><i class="bi bi-car-front-fill"></i> Total Kendaraan</h5>
                    <h2 class="fw-bold"><?= $total_kendaraan; ?></h2>
                    <a href="kendaraan.php" class="btn btn-success w-100 mt-2 rounded-pill">
                        Lihat Kendaraan
                    </a>
                </div>
            </div>
        </div>

        <!-- Peminjaman Aktif -->
        <div class="col-md-3 mb-3">
            <div class="card shadow rounded-4 border-0" style="background:#fff7cd;">
                <div class="card-body text-center">
                    <h5 class="fw-bold text-warning"><i class="bi bi-hourglass-split"></i> Dipinjam</h5>
                    <h2 class="fw-bold"><?= $total_pinjam_aktif; ?></h2>
                    <a href="pinjam.php" class="btn btn-warning w-100 text-dark mt-2 rounded-pill">
                        Lihat Pinjaman
                    </a>
                </div>
            </div>
        </div>

        <!-- Pinjaman Selesai -->
        <div class="col-md-3 mb-3">
            <div class="card shadow rounded-4 border-0" style="background:#f3e8ff;">
                <div class="card-body text-center">
                    <h5 class="fw-bold text-purple"><i class="bi bi-check-circle-fill"></i> Selesai</h5>
                    <h2 class="fw-bold"><?= $total_pinjam_selesai; ?></h2>
                    <a href="pinjam.php" class="btn btn-secondary w-100 mt-2 rounded-pill">
                        Riwayat Pinjam
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Riwayat Terbaru -->
    <div class="mt-5">
        <h4 class="fw-bold"><i class="bi bi-clock-history"></i> Riwayat Peminjaman Terbaru</h4>

        <table class="table table-striped mt-3 shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Kendaraan</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $q = mysqli_query($conn, "
                    SELECT p.*, u.user_nama, k.kendaraan_nama 
                    FROM pinjam p
                    JOIN user u ON u.user_id = p.user_id
                    JOIN kendaraan k ON k.kendaraan_id = p.kendaraan_id
                    ORDER BY p.pinjam_id DESC LIMIT 10
                ");

                while ($t = mysqli_fetch_assoc($q)) {
                ?>
                <tr>
                    <td><?= $t['pinjam_id']; ?></td>
                    <td><?= $t['user_nama']; ?></td>
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

