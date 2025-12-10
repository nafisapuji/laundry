<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['status']) || $_SESSION['status']!='login' || $_SESSION['user_status']!='admin'){
    header("Location: index.php");
    exit();
}

$aksi = $_GET['aksi'] ?? '';
$kendaraan_id = $_GET['id'] ?? '';

switch($aksi){
    case 'tambah':
        if(isset($_POST['simpan'])){
            $nama = $_POST['kendaraan_nama'];
            $tipe = $_POST['kendaraan_tipe'];
            $harga = $_POST['kendaraan_harga_perhari'];
            $status = $_POST['kendaraan_status'];

            $insert = mysqli_query($conn,"INSERT INTO kendaraan (kendaraan_nama,kendaraan_tipe,kendaraan_harga_perhari,kendaraan_status) 
                VALUES ('$nama','$tipe','$harga','$status')");
            if($insert) header("Location: kendaraan.php");
        }
        break;

    case 'edit':
        if(isset($_POST['update'])){
            $nama = $_POST['kendaraan_nama'];
            $tipe = $_POST['kendaraan_tipe'];
            $harga = $_POST['kendaraan_harga_perhari'];
            $status = $_POST['kendaraan_status'];

            mysqli_query($conn,"UPDATE kendaraan SET kendaraan_nama='$nama',kendaraan_tipe='$tipe',kendaraan_harga_perhari='$harga',kendaraan_status='$status' WHERE kendaraan_id='$kendaraan_id'");
            header("Location: kendaraan.php");
        }
        break;

    case 'hapus':
        if($kendaraan_id!=''){
            mysqli_query($conn,"DELETE FROM kendaraan WHERE kendaraan_id='$kendaraan_id'");
            header("Location: kendaraan.php");
        }
        break;

    default:
        echo "Aksi tidak dikenali.";
        break;
}
