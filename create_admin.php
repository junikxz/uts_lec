// File: create_admin.php
<?php
require 'config/db.php';

$password = password_hash('admin123', PASSWORD_BCRYPT);

$stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, ?)");
$stmt->execute(['Admin', 'admin@gmail.com', $password, 1]);

echo "Admin created successfully!";
?>
