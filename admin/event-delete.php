<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM event WHERE id = ?");
if ($stmt->execute([$id])) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error deleting event!";
}
?>
