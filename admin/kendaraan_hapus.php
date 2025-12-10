<?php
session_start();
include '../koneksi.php';

// CEK LOGIN ADMIN
if(!isset($_SESSION['status']) || $_SESSION['status'] != 'login' || $_SESSION['user_status'] != 'admin'){
    header("Location: index.php");
    exit();
}

// Ambil kendaraan_id dari URL
$kendaraan_id = $_GET['id'] ?? '';

if($kendaraan_id == ''){
    echo "<script>alert('Kendaraan tidak ditemukan'); window.location='kendaraan.php';</script>";
    exit();
}

// Hapus kendaraan
$delete = mysqli_query($conn, "DELETE FROM kendaraan WHERE kendaraan_id='$kendaraan_id'");

if($delete){
    echo "<script>alert('Kendaraan berhasil dihapus'); window.location='kendaraan.php';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan, kendaraan gagal dihapus'); window.location='kendaraan.php';</script>";
}
