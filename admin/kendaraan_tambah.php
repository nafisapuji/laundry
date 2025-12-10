<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../koneksi.php';
include 'header.php';

// CEK LOGIN ADMIN
if(!isset($_SESSION['status']) || $_SESSION['status']!='login' || $_SESSION['user_status']!='admin'){
    header("Location: index.php");
    exit();
}
?>

<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-plus-circle"></i> Tambah Kendaraan Baru</h2>

    <div class="card shadow-sm p-4 rounded-4">
        <form method="POST" action="kendaraan_aksi.php?aksi=tambah">
            <div class="mb-4">
                <label for="kendaraan_nama" class="form-label">Nama Kendaraan</label>
                <input type="text" name="kendaraan_nama" id="kendaraan_nama" class="form-control" placeholder="Masukkan nama kendaraan" required>
            </div>

            <div class="mb-3">
                <label for="kendaraan_tipe" class="form-label">Tipe Kendaraan</label>
                <input type="text" name="kendaraan_tipe" id="kendaraan_tipe" class="form-control" placeholder="Masukkan tipe kendaraan" required>
            </div>

            <div class="mb-3">
                <label for="kendaraan_harga_perhari" class="form-label">Harga per Hari (Rp)</label>
                <input type="number" name="kendaraan_harga_perhari" id="kendaraan_harga_perhari" class="form-control" placeholder="Masukkan harga per hari" required>
            </div>

            <div class="mb-3">
                <label for="kendaraan_status" class="form-label">Status Kendaraan</label>
                <select name="kendaraan_status" id="kendaraan_status" class="form-select" required>
                    <option value="Tersedia" selected>Tersedia</option>
                    <option value="Dipinjam">Dipinjam</option>
                </select>
            </div>

            <button type="submit" name="simpan" class="btn btn-success w-100 rounded-pill">
                <i class="bi bi-plus-circle"></i> Tambah Kendaraan
            </button>
        </form>

        <a href="kendaraan.php" class="btn btn-secondary w-100 rounded-pill mt-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
