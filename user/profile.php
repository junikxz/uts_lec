<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$events = $pdo->prepare("SELECT e.* FROM events e INNER JOIN registrations r ON e.id = r.event_id WHERE r.user_id = ?");
$events->execute([$user_id]);
$registered_events = $events->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>User Profile</h1>
        <div class="card">
            <div class="card-body">
                <h3><?= htmlspecialchars($user['name']) ?></h3>
                <p>Email: <?= htmlspecialchars($user['email']) ?></p>
                <a href="event-list.php" class="btn btn-primary">Browse Events</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <h2 class="mt-4">Registered Events</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registered_events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['name']) ?></td>
                        <td><?= htmlspecialchars($event['date']) ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                        <td>
                            <a href="event-detail.php?id=<?= $event['id'] ?>" class="btn btn-info">View Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
