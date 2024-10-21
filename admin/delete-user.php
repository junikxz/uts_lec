<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$user_id = $_GET['id'];
if (!filter_var($user_id, FILTER_VALIDATE_INT)) {
    header('Location: user-management.php'); 
    exit();
}

$delete_registrations = $pdo->prepare("DELETE FROM registrations WHERE user_id = ?");
if ($delete_registrations->execute([$user_id])) {
    echo "Registrations deleted.<br>"; 
}

// Hapus data user dari tabel `user`
$stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
if ($stmt->execute([$user_id])) {
    echo "User deleted.<br>"; 
    header('Location: user-management.php');
    exit();
} else {
    echo "Error deleting user!"; 
    header('Location: user-management.php');
    exit();
}
