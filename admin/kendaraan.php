<?php
session_start();
include '../koneksi.php';
include 'header.php';

// Cek login admin
if(!isset($_SESSION['status']) || $_SESSION['status'] != 'login' || $_SESSION['user_status'] != 'admin'){
    header("Location: index.php");
    exit();
}

// Ambil data kendaraan
$kendaraan = mysqli_query($conn, "SELECT * FROM kendaraan ORDER BY kendaraan_id DESC");
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Daftar Kendaraan</h2>
        <a href="kendaraan_tambah.php" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Kendaraan
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Harga / Hari</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($kendaraan) > 0): ?>
                            <?php while($k = mysqli_fetch_assoc($kendaraan)) : ?>
                                <tr>
                                    <td class="text-center"><?= $k['kendaraan_id']; ?></td>
                                    <td><?= htmlspecialchars($k['kendaraan_nama']); ?></td>
                                    <td><?= htmlspecialchars($k['kendaraan_tipe']); ?></td>
                                    <td>Rp <?= number_format($k['kendaraan_harga_perhari'], 0, ',', '.'); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($k['kendaraan_status']); ?></td>
                                    <td class="text-center">
                                       <a href="kendaraan_edit.php?id=<?= $k['kendaraan_id']; ?>" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>

                                        <a href="kendaraan_hapus.php?id=<?= $k['kendaraan_id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?');"><i class="bi bi-trash"></i> Hapus</a>

                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data kendaraan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
