<?php
session_start();
include '../koneksi.php';

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

// Hapus user
$delete = mysqli_query($conn, "DELETE FROM user WHERE user_id='$user_id'");

if($delete){
    echo "<script>alert('User berhasil dihapus'); window.location='user.php';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan, user gagal dihapus'); window.location='user.php';</script>";
}
