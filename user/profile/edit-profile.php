<?php
session_start();
require '../../config/db.php'; 

// Ambil informasi user berdasarkan session user_id
$user_id = $_SESSION['user_id'];
$user = $pdo->prepare("SELECT * FROM user WHERE id = ?");
$user->execute([$user_id]);
$user_info = $user->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $old_password = $_POST['old_password'] ?? null;
    $new_password = $_POST['new_password'] ?? null;
    $confirm_password = $_POST['confirm_password'] ?? null;

    // Validasi data umum (nama dan email)
    if (empty($name) || empty($email)) {
        $error = "Nama dan email harus diisi.";
    } else {
        // Update informasi user di database
        $stmt = $pdo->prepare("UPDATE user SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$name, $email, $user_id]);

        // Jika ada permintaan ubah password
        if (!empty($old_password) && !empty($new_password) && !empty($confirm_password)) {
            // Periksa apakah password lama benar
            if (password_verify($old_password, $user_info['password'])) {
                if ($new_password === $confirm_password) {
                    // Update password di database
                    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE user SET password = ? WHERE id = ?");
                    $stmt->execute([$new_password_hashed, $user_id]);

                    // Redirect ke profile.php dengan parameter success
                    header("Location: profile.php?success=1");
                    exit();
                } else {
                    $error = "Konfirmasi password tidak cocok.";
                }
            } else {
                $error = "Password lama salah.";
            }
        } else {
            // Redirect ke profile.php tanpa mengubah password
            header("Location: profile.php?success=1");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Profile</h2>

        <!-- Cek jika ada error -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="edit-profile.php">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($user_info['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user_info['email']) ?>" required>
            </div>

            <h4>Ubah Password</h4>
            <div class="mb-3">
                <label for="old_password" class="form-label">Password Lama</label>
                <input type="password" name="old_password" id="old_password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" name="new_password" id="new_password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
