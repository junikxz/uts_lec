<?php
session_start();
require '../config/db.php';  

if (isset($_POST['forget_password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ? AND email = ?");
    $stmt->execute([$username, $email]);
    $user = $stmt->fetch();

    if ($result->num_rows > 0) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ? AND username = ?");
        $stmt->bind_param("sss", $hashedPassword, $email, $username);
        $stmt->execute();

        echo "Password Anda telah diperbarui.";
    } else {
        echo "Email dan username tidak cocok.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">Forget Password</div>
                    <div class="card-body">
                        <?php if (isset($message)) echo $message; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            <button type="password" name="new_password" class="btn btn-danger">Reset Password</button>
                        </form>
                        <a href="login.php" class="btn btn-link mt-3">Kembali ke Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
