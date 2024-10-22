<?php
session_start();
require '../config/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $cpassword = $_POST['cpass'];
    $role = $_POST['role'];

    if ($password !== $cpassword) {
        echo "<script>
            alert('Passwords do not match!');
            window.location.href = 'signup.php';
            </script>";
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ? UNION SELECT * FROM admin WHERE email = ?");
    $stmt->execute([$email, $email]);
    $existingEmail = $stmt->fetch();

    if ($existingEmail) {
        echo "<script>
            alert('Email already used!');
            window.location.href = 'signup.php';
            </script>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($role === 'admin') {
            $stmt = $pdo->prepare("INSERT INTO admin (name, email, password) VALUES (?, ?, ?)");
        } else {
            $stmt = $pdo->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
        }

        if ($stmt->execute([$username, $email, $hashedPassword])) {
            echo "<script>
                alert('Signup successful! Please login.');
                window.location.href = '../dashboard.php';
                </script>";
        } else {
            echo "<script>
                alert('Signup failed! Please try again.');
                window.location.href = 'signup.php';
                </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Sign Up</title>
</head>
<body>
<div class="container mt-5">
    <h1 id="heading" class="text-center">SignUp</h1>
    <form name="SignUpForm" class="mx-auto w-50" action="signup.php" method="POST">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="user" name="user" placeholder="Username" required>
            <label for="user">Username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" required>
            <label for="pass">Password</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="cpass" name="cpass" placeholder="Confirm Password" required>
            <label for="cpass">Confirm Password</label>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <div>
                <input type="radio" id="r-user" name="role" value="user" required>
                <label for="r-user" class="me-3">User</label>

                <input type="radio" id="r-admin" name="role" value="admin" required>
                <label for="r-admin">Admin</label>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100">Submit</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>