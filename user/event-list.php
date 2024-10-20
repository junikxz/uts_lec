<?php
session_start();
require '../config/db.php';

// Fetch events from database
$events = $pdo->query("SELECT * FROM events WHERE date >= CURDATE()")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['user_id'];

    // Register user to the event
    $stmt = $pdo->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
    if ($stmt->execute([$user_id, $event_id])) {
        echo "<div class='alert alert-success'>Registered successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error registering!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Available Events</h1>
        <div class="row">
            <?php foreach ($events as $event): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" class="card-img-top" alt="Event Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($event['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                            <p class="card-text"><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                            <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                            <form method="POST">
                                <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
