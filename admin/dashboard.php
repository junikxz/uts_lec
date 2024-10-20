<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$events = $pdo->query("
    SELECT e.*, COUNT(r.id) AS total_registered 
    FROM events e
    LEFT JOIN registrations r ON e.id = r.event_id
    GROUP BY e.id
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Admin Dashboard</h1>
            <a href="event-create.php" class="btn btn-primary">Create New Event</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <div class="row mt-4">
            <?php if (count($events) > 0): ?>
                <?php foreach ($events as $event): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" class="card-img-top" alt="Event Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($event['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                                <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                                <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                                <p><strong>Total Registered:</strong> <?= $event['total_registered'] ?>/<?= $event['max_participants'] ?></p>
                                <div class="d-flex justify-content-between">
                                    <a href="event-registrations.php?id=<?= $event['id'] ?>" class="btn btn-info">View Registrants</a>
                                    <a href="event-edit.php?id=<?= $event['id'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="event-delete.php?id=<?= $event['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No events found. <a href="event-create.php">Create a new event</a>.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
