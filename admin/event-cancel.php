<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    $stmt = $pdo->prepare("UPDATE event SET status = 'canceled' WHERE id = ?");
    if ($stmt->execute([$event_id])) {
        header('Location: dashboard.php#cancelled-events');
        exit();
    } else {
        echo "Failed to cancel event.";
    }
} else {
    echo "Invalid event ID.";
}
?>
