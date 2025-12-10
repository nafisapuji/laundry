<?php
session_start();
include '../koneksi.php';
include 'header.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login" || $_SESSION['user_status'] != "user") {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil semua peminjaman user
$query = mysqli_query($conn, "
    SELECT p.*, k.kendaraan_nama, k.kendaraan_tipe 
    FROM pinjam p
    JOIN kendaraan k ON p.kendaraan_id = k.kendaraan_id
    WHERE p.user_id='$user_id'
    ORDER BY p.pinjam_id DESC
");
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-4"><i class="bi bi-clock-history"></i> Riwayat Peminjaman</h2>

    <table class="table table-striped shadow-sm">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Kendaraan</th>
                <th>Tipe</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?= $row['pinjam_id']; ?></td>
                <td><?= $row['kendaraan_nama']; ?></td>
                <td><?= $row['kendaraan_tipe']; ?></td>
                <td><?= $row['tgl_pinjam']; ?></td>
                <td><?= $row['tgl_kembali']; ?></td>
                <td><?= $row['pinjam_status']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
</div>
