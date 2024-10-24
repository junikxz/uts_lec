<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$id = $_GET['id'];

$registrant_check = $pdo->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ?");
$registrant_check->execute([$id]);
$registrant_count = $registrant_check->fetchColumn();

if ($registrant_count > 0) {
    echo "<script>
        alert('Event cannot be deleted because there are registered participants.');
        window.location.href = 'dashboard.php';
    </script>";
    exit();
}

$stmt = $pdo->prepare("DELETE FROM event WHERE id = ?");
if ($stmt->execute([$id])) {
    echo "<script>
        alert('Event has been successfully deleted.');
        window.location.href = 'dashboard.php';
    </script>";
    exit();
} else {
    echo "<script>
        alert('Error deleting event!');
        window.location.href = 'dashboard.php';
    </script>";
}
