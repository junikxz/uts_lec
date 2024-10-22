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
            $stmt = $pdo->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
        } else {
            $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
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
