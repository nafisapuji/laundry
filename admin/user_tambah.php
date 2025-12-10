<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../koneksi.php';
include 'header.php';

// CEK LOGIN ADMIN
if(!isset($_SESSION['status']) || $_SESSION['user_status'] != 'admin'){
    header("Location: index.php");
    exit();
}

// Proses form jika disubmit
if(isset($_POST['simpan'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $user_nama = $_POST['user_nama'];
    $user_alamat = $_POST['user_alamat'];
    $user_status = $_POST['user_status'];

    // Insert ke tabel user
    $insert = mysqli_query($conn, "
        INSERT INTO user (username, password, user_nama, user_alamat, user_status)
        VALUES ('$username', '$password', '$user_nama', '$user_alamat', '$user_status')
    ");

    if($insert){
        echo "<script>alert('User berhasil ditambahkan'); window.location='user.php';</script>";
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan, silakan coba lagi'); window.history.back();</script>";
        exit();
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-person-plus"></i> Tambah User Baru</h2>

    <div class="card shadow-sm p-4 rounded-4">
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <div class="mb-3">
                <label for="user_nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="user_nama" id="user_nama" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="mb-3">
                <label for="user_alamat" class="form-label">Alamat</label>
                <textarea name="user_alamat" id="user_alamat" class="form-control" placeholder="Masukkan alamat" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="user_status" class="form-label">Status User</label>
                <select name="user_status" id="user_status" class="form-select" required>
                    <option value="user" selected>User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" name="simpan" class="btn btn-success w-100 rounded-pill">
                <i class="bi bi-plus-circle"></i> Tambah User
            </button>
        </form>

        <a href="user.php" class="btn btn-secondary w-100 rounded-pill mt-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
