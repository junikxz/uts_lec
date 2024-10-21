<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register_user'])) {
        $username = $_POST['username_user'];
        $email = $_POST['email_user'];
        $password = password_hash($_POST['password_user'], PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            echo "<div class='alert alert-danger'>Email sudah terdaftar!</div>";
        } else {
            $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $password])) {
                echo "<div class='alert alert-success'>Registrasi user berhasil! Silakan login.</div>";
            } else {
                echo "<div class='alert alert-danger'>Registrasi user gagal. Silakan coba lagi.</div>";
            }
        }
    } elseif (isset($_POST['register_admin'])) {
        $username = $_POST['username_admin'];
        $email = $_POST['email_admin'];
        $password = password_hash($_POST['password_admin'], PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $existingAdmin = $stmt->fetch();

        if ($existingAdmin) {
            echo "<div class='alert alert-danger'>Email sudah terdaftar!</div>";
        } else {
            $stmt = $pdo->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $password])) {
                echo "<div class='alert alert-success'>Registrasi admin berhasil! Silakan login.</div>";
            } else {
                echo "<div class='alert alert-danger'>Registrasi admin gagal. Silakan coba lagi.</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">User Registration</div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username_user" class="form-label">Username</label>
                                <input type="text" name="username_user" class="form-control" id="username_user" required>
                            </div>
                            <div class="mb-3">
                                <label for="email_user" class="form-label">Email</label>
                                <input type="email" name="email_user" class="form-control" id="email_user" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_user" class="form-label">Password</label>
                                <input type="password" name="password_user" class="form-control" id="password_user" required>
                            </div>
                            <button type="submit" name="register_user" class="btn btn-primary">Register User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-white">Admin Registration</div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username_admin" class="form-label">Username</label>
                                <input type="text" name="username_admin" class="form-control" id="username_admin" required>
                            </div>
                            <div class="mb-3">
                                <label for="email_admin" class="form-label">Email</label>
                                <input type="email" name="email_admin" class="form-control" id="email_admin" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_admin" class="form-label">Password</label>
                                <input type="password" name="password_admin" class="form-control" id="password_admin" required>
                            </div>
                            <button type="submit" name="register_admin" class="btn btn-warning">Register Admin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
