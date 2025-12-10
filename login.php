<?php
session_start();
include 'koneksi.php';

$input = $_POST['username']; // bisa username atau nama
$password = $_POST['password'];

// Validasi form
if (empty($input) || empty($password)) {
    header("Location: index.php?pesan=gagal");
    exit();
}

// CARI USER BERDASARKAN username ATAU user_nama
$sql = "SELECT * FROM user 
        WHERE username='$input' 
        OR user_nama='$input'";

$data = mysqli_query($conn, $sql);

if (mysqli_num_rows($data) > 0) {
    $user = mysqli_fetch_assoc($data);

    // Cek password
    if ($password == $user['password']) {

        // SET SESSION
        $_SESSION['user_id']     = $user['user_id'];
        $_SESSION['username']    = $user['username'];
        $_SESSION['user_nama']   = $user['user_nama'];
        $_SESSION['user_status'] = $user['user_status'];
        $_SESSION['status']      = "login";

        // ARAHKAN BERDASAR ROLE
        if ($user['user_status'] == "admin") {
            header("Location: admin/index.php");
        } else {
            header("Location: user/index.php");
        }
        exit();

    } else {
        // Password salah
        header("Location: index.php?pesan=gagal");
        exit();
    }
} else {
    // Username / nama tidak ditemukan
    header("Location: index.php?pesan=gagal");
    exit();
}
?>
