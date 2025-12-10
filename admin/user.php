<?php
session_start();
include '../koneksi.php';
include 'header.php';

// CEK LOGIN ADMIN
if(!isset($_SESSION['status']) || $_SESSION['user_status'] != 'admin'){
    header("Location: index.php");
    exit();
}

// Ambil semua data user
$query = mysqli_query($conn, "SELECT * FROM user ORDER BY user_id DESC");
?>

<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-people"></i> Data User</h2>

    <!-- Tombol tambah user -->
    <a href="user_tambah.php" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Tambah User
    </a>

    <table class="table table-striped table-bordered shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?= $user['user_id']; ?></td>
                <td><?= $user['username']; ?></td>
                <td><?= $user['user_nama']; ?></td>
                <td><?= $user['user_alamat']; ?></td>
                <td><?= $user['user_status']; ?></td>
                <td>
                    <a href="user_edit.php?id=<?= $user['user_id']; ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="user_hapus.php?id=<?= $user['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                        <i class="bi bi-trash"></i> Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
