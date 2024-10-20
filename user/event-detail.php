<?php
session_start();
require '../config/db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();

if (!$event) {
    echo "Event not found!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $additional_info = $_POST['additional_info'];
    $user_id = $_SESSION['user_id'];

    // Check if event is full
    $registration_count = $pdo->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ?");
    $registration_count->execute([$id]);
    $total_registered = $registration_count->fetchColumn();

    if ($total_registered >= $event['max_participants']) {
        echo "<div class='alert alert-danger'>Sorry, the event is full!</div>";
    } else {
        // Insert user registration
        $stmt = $pdo->prepare("INSERT INTO registrations (user_id, event_id, name, additional_info) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$user_id, $id, $name, $additional_info])) {
            echo "<div class='alert alert-success'>Successfully registered!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error registering for event!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1><?= htmlspecialchars($event['name']) ?></h1>
        <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" class="img-fluid" alt="Event Image">
        <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($event['description']) ?></p>

        <!-- Form untuk registrasi event -->
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="additional_info" class="form-label">Additional Info (Address, Phone, etc.)</label>
                <textarea name="additional_info" class="form-control" id="additional_info" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <a href="event-list.php" class="btn btn-secondary mt-3">Back to Event List</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
