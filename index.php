<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Rental Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #0d1117;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Poppins", sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: #161b22;
            border-radius: 14px;
            padding: 35px 28px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.6);
            color: white;
            border: 1px solid #30363d;
        }

        .title {
            text-align: center;
            margin-bottom: 25px;
        }

        .title h2 {
            font-weight: 700;
        }

        .form-control {
            background: #0d1117;
            border: 1px solid #30363d;
            color: white;
            border-radius: 10px;
        }

        .form-control:focus {
            border-color: #58a6ff;
            box-shadow: 0 0 0 .2rem rgba(56, 139, 253, 0.25);
            background: #0d1117;
            color: #fff;
        }

        .form-control::placeholder {
            color: #8b949e;
        }

        .btn-login {
            width: 100%;
            background: #238636;
            border: none;
            padding: 10px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 10px;
            transition: .3s;
            color: white;
        }

        .btn-login:hover {
            background: #2ea043;
        }

        .login-info {
            background: #21262d;
            border-left: 4px solid #58a6ff;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            color: #c9d1d9;
            font-size: 14px;
        }

        .alert {
            border-radius: 10px;
        }

        code {
            background: #30363d;
            padding: 2px 5px;
            border-radius: 5px;
            color: #58a6ff;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="title">
            <h2>Sistem Rental Kendaraan</h2>
            <p class="text-secondary">Silakan login untuk melanjutkan</p>
        </div>

        <?php 
            if (isset($_GET['pesan'])) {
                if ($_GET['pesan']=="gagal"){
                    echo "<div class='alert alert-danger'>Login Gagal! Username atau Password salah!</div>";
                } elseif ($_GET['pesan']=="logout"){
                    echo "<div class='alert alert-info'>Anda berhasil logout.</div>";
                } elseif ($_GET['pesan']=="belum_login"){
                    echo "<div class='alert alert-warning'>Anda harus login terlebih dahulu!</div>";
                }
            }
        ?>


        <form method="post" action="login.php">
            <div class="mb-3">
                <label class="form-label">Username / User Nama</label>
                <input type="text" class="form-control" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

    </div>

</body>
</html>
