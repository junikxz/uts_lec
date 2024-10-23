<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }

        .header-title {
            position: relative;
            width: 100%;
            height: 100vh;
            background-image: url('index.png');
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            z-index: 1;
        }

        .header-title h1 {
            font-size: 4rem;
            font-weight: bold;
        }

        .header-title h3 {
            font-weight: bold;
        }

        .header-title p {
            font-size: 1.2rem;
        }

        .btn-custom {
            margin: 10px;
            padding: 15px 30px;
            font-size: 1.25rem;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .btn-register {
            background-color: #2a2a71;
            color: white;
        }

        .btn-login {
            border: 2px solid #3a3a91;
            color: #3a3a91;
            background-color: transparent;
        }

        .btn-login:hover {
            background-color: #3a3a91;
            color: white;
        }

        .btn-register:hover {
            background-color: #2a2a90;
        }
    </style>
</head>

<body>
    <div class="header-title">
        <div>
            <h1>Welcome to Menarik Nih</h1>
            <h3>Manajemen Event dengan Navigasi yang Aktif, Responsif, dan Informasi yang Kolaboratif</h3>
            <a href="signup/signup.php" class="btn btn-custom btn-register">Register</a>
            <a href="user/login.php" class="btn btn-custom btn-login">Login</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>