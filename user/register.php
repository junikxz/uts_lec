<?php
session_start();
require '../config/db.php';

// // Cek apakah user sudah login
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// Ambil ID user dari session dan event ID dari form
// $user_id = $_SESSION['user_id'];
$event_id = $_POST['event_id'] ?? null;

if (!$event_id) {
    echo "No event selected!";
    exit();
}

// Cek apakah event ID valid
$stmt = $pdo->prepare("SELECT id FROM event WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    echo "Event not found!";
    exit();
}

// Insert data registrasi
$stmt = $pdo->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
if ($stmt->execute([$user_id, $event_id])) {
    echo "You have successfully registered for the event!";
} else {
    echo "Registration failed!";
}
?>
