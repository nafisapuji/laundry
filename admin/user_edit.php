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

// Ambil user_id dari URL
$user_id = $_GET['id'] ?? '';

if($user_id == ''){
    echo "<script>alert('User tidak ditemukan'); window.location='user.php';</script>";
    exit();
}

// Ambil data user dari database
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE user_id='$user_id'"));

if(!$user){
    echo "<script>alert('User tidak ditemukan'); window.location='user.php';</script>";
    exit();
}

// Proses form jika disubmit
if(isset($_POST['update'])){
    $username = $_POST['username'];
    $user_nama = $_POST['user_nama'];
    $user_alamat = $_POST['user_alamat'];
    $user_status = $_POST['user_status'];

    // Cek apakah password diubah
    if(!empty($_POST['password'])){
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $update = mysqli_query($conn, "
            UPDATE user SET 
                username='$username', 
                password='$password', 
                user_nama='$user_nama', 
                user_alamat='$user_alamat', 
                user_status='$user_status' 
            WHERE user_id='$user_id'
        ");
    } else {
        $update = mysqli_query($conn, "
            UPDATE user SET 
                username='$username', 
                user_nama='$user_nama', 
                user_alamat='$user_alamat', 
                user_status='$user_status' 
            WHERE user_id='$user_id'
        ");
    }

    if($update){
        echo "<script>alert('Data user berhasil diperbarui'); window.location='user.php';</script>";
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan, silakan coba lagi'); window.history.back();</script>";
        exit();
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-pencil-square"></i> Edit User</h2>

    <div class="card shadow-sm p-4 rounded-4">
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="<?= $user['username']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password <small>(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password baru">
            </div>

            <div class="mb-3">
                <label for="user_nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="user_nama" id="user_nama" class="form-control" value="<?= $user['user_nama']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="user_alamat" class="form-label">Alamat</label>
                <textarea name="user_alamat" id="user_alamat" class="form-control" rows="3" required><?= $user['user_alamat']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="user_status" class="form-label">Status User</label>
                <select name="user_status" id="user_status" class="form-select" required>
                    <option value="user" <?= $user['user_status']=='user'?'selected':''; ?>>User</option>
                    <option value="admin" <?= $user['user_status']=='admin'?'selected':''; ?>>Admin</option>
                </select>
            </div>

            <button type="submit" name="update" class="btn btn-primary w-100 rounded-pill">
                <i class="bi bi-save"></i> Simpan Perubahan
            </button>
        </form>

        <a href="user.php" class="btn btn-secondary w-100 rounded-pill mt-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
