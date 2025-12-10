<?php
session_start();
include '../koneksi.php';
include 'header.php';

if(!isset($_SESSION['status']) || $_SESSION['status']!='login' || $_SESSION['user_status']!='admin'){
    header("Location: index.php");
    exit();
}
$pinjam = mysqli_query($conn, "
    SELECT p.*, k.kendaraan_nama, u.user_nama
    FROM pinjam p
    JOIN kendaraan k ON p.kendaraan_id = k.kendaraan_id
    JOIN user u ON p.user_id = u.user_id
    ORDER BY p.pinjam_id DESC
");

?>

<div class="container mt-4">
    <h2>Daftar Peminjaman</h2>
    <table class="table table-striped table-bordered">
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
            <?php while($p=mysqli_fetch_assoc($pinjam)){ ?>
            <tr>
                <td><?= $p['pinjam_id']; ?></td>
                <td><?= $p['user_nama']; ?></td>
                <td><?= $p['kendaraan_nama']; ?></td>
                <td><?= $p['tgl_pinjam']; ?></td>
                <td><?= $p['tgl_kembali']; ?></td>
                <td><?= $p['pinjam_status']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
