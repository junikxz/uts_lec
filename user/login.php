<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']); 
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if (!empty($admin)) {
        if(password_verify($password, $admin['password'])){
            $_SESSION['admin'] = $admin['id'];
            header('Location: ../admin/dashboard.php');
            exit();
        } else {
            echo $errorMessage = "Invalid credentials!";
        }
    } else {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(); 
        if($user){
            if(password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['id'];
                header('Location: homepage/homepage.php');
                exit();
            } else {
            echo $errorMessage = "Invalid credentials!";
            }
        } else {
            echo $errorMessage = "Invalid credentials!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .login-container {
            display: flex;
            width: 80%;
            max-width: 900px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .login-image {
            width: 50%;
            background: url('images/login-picture.jpeg') no-repeat center center;
            background-size: cover;
        }

        .login-form {
            width: 50%;
            padding: 40px;
            background-color: #fff;
        }

        .login-header {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #0984e3;
        }

        .form-control {
            border-radius: 25px;
            margin-bottom: 20px;
            border: 2px solid #74b9ff;
        }

        .btn-login {
            width: 100%;
            border-radius: 25px;
            background-color: #0984e3;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #6c5ce7;
        }

        .forget-password {
            text-align: center;
            margin-top: 15px;
        }

        .forget-password a {
            color: #0984e3;
            text-decoration: none;
            font-weight: bold;
        }

        .forget-password a:hover {
            text-decoration: underline;
        }

        .alert-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-image"></div>

        <div class="login-form">
            <div class="login-header">Welcome Back!</div>
            <?php if (isset($errorMessage)): ?>
                <div class="alert-container">
                    <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
                </div>
            <?php endif; ?>
            <form method="POST">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button type="submit" class="btn btn-login">Login</button>
            </form>

            <div class="forget-password">
                <a href="forget-password.php">Forgot Password?</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
