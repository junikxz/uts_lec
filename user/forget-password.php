<?php
session_start();
require '../config/db.php'; 

if (isset($_POST['reset_password'])) {
    $username = htmlspecialchars($_POST['username']); 
    $email = htmlspecialchars($_POST['email']); 
    $newPassword = $_POST['new_password'];
    $phone = htmlspecialchars($_POST['phone']); 
    $birthdate = htmlspecialchars($_POST['birthdate']); 

    $stmt = $pdo->prepare("SELECT * FROM user WHERE name = ? AND email = ? AND phone_number = ? AND birthdate = ?");
    $stmt->execute([$username, $email, $phone, $birthdate]);
    $user = $stmt->fetch();

    if ($user) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $pdo->prepare("UPDATE user SET password = ? WHERE email = ? AND name = ?");
        $updateStmt->execute([$hashedPassword, $email, $username]);

        $message = "Password Anda telah diperbarui.";
    } else {
        $message = "Data tidak cocok.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('images/background.png') no-repeat center center;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
        }

        .reset-container {
            display: flex;
            width: 80%;
            max-width: 900px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .reset-image {
            width: 50%;
            background: url('images/login-picture.jpeg') no-repeat center center;
            background-size: cover;
        }

        .reset-form {
            width: 50%;
            padding: 40px;
            background-color: #fff;
        }

        .reset-header {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #d63031;
        }

        .form-control {
            border-radius: 25px;
            margin-bottom: 15px;
            border: 2px solid #fd79a8;
        }

        .btn-reset {
            width: 100%;
            border-radius: 25px;
            background-color: #e84393;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-reset:hover {
            background-color: #6c5ce7;
        }

        .back-to-login {
            text-align: center;
            margin-top: 15px;
        }

        .back-to-login a {
            color: #0984e3;
            text-decoration: none;
            font-weight: bold;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="reset-container">
        <div class="reset-image"></div>

        <div class="reset-form">
            <div class="reset-header">Reset Password</div>
            <?php if (isset($message)) echo '<div class="alert alert-info">' . htmlspecialchars($message) . '</div>'; ?>
            <form method="POST">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
                <input type="date" name="birthdate" class="form-control" required>
                <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                <button type="submit" name="reset_password" class="btn btn-reset">Reset Password</button>
            </form>

            <div class="back-to-login">
                <a href="login.php">Back to Login</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
