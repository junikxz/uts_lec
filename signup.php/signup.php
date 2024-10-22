<?php 
    include("connection.php");
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
    <form name="SignUpForm" class="mx-auto w-75" action="signup.php" method="POST">
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