<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login" || $_SESSION['user_status'] != "user") {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Rental</title>

    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #dbeafe, #f3e8ff, #fff);
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar-custom {
            background: linear-gradient(90deg, #0061ff, #5b9dff);
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            padding: 20px;
            background: #ffffff;
            border-right: 2px solid #e0e0e0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }

        .sidebar h5 {
            font-weight: bold;
            color: #444;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            margin-bottom: 8px;
            color: #444;
            font-weight: 500;
            border-radius: 10px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a i {
            font-size: 1.2rem;
        }

        .sidebar a:hover {
            background: linear-gradient(120deg, #4f8cff, #6ea8fe);
            color: white;
            transform: scale(1.03);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        /* CONTENT */
        .content {
            margin-left: 260px;
            padding: 25px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-car-front-fill"></i> Rental Skanega - User
        </a>

        <div>
            <span class="text-white me-3">
                <i class="bi bi-person-circle"></i> Halo, <?= $_SESSION['user_nama']; ?>
            </span>
            <a href="../logout.php">Logout</a>



        </div>
    </div>
</nav>

<div class="sidebar">
    <h5><i class="bi bi-grid-fill"></i> Menu User</h5>

    <a href="index.php">
        <i class="bi bi-speedometer"></i> Dashboard
    </a>

    <a href="kendaraan.php">
        <i class="bi bi-car-front-fill"></i> Kendaraan Tersedia
    </a>

    <a href="pinjam.php">
        <i class="bi bi-clock-history"></i> Riwayat Pinjam
    </a>
</div>

<div class="content">
