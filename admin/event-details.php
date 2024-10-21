<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$event_id = $_GET['id'] ?? null; 
if ($event_id === null) {
    echo "<div class='alert alert-danger'>Event ID is missing!</div>";
    exit();
}


$stmt = $pdo->prepare("SELECT * FROM event WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    echo "<div class='alert alert-danger'>Event not found!</div>";
    exit();
}


$registrants = $pdo->prepare("
    SELECT user.username, user.email, registrations.created_at 
    FROM registrations 
    JOIN user ON registrations.user_id = user.id 
    WHERE registrations.event_id = ?
");
$registrants->execute([$event_id]);
$registrant_list = $registrants->fetchAll();
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
        <h1>Event: <?= htmlspecialchars($event['name']) ?></h1>
        <p><strong>Description:</strong> <?= htmlspecialchars($event['description']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
        <p><strong>Time:</strong> <?= htmlspecialchars($event['time']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
        <p><strong>Max Participants:</strong> <?= htmlspecialchars($event['max_participants']) ?></p>

        <h3>Registrants</h3>
        <?php if (count($registrant_list) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrant_list as $registrant): ?>
                        <tr>
                            <td><?= htmlspecialchars($registrant['username']) ?></td>
                            <td><?= htmlspecialchars($registrant['email']) ?></td>
                            <td><?= htmlspecialchars($registrant['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No registrants for this event yet.</p>
        <?php endif; ?>

        <div class="d-flex justify-content-between mt-3">
            <a href="event-edit.php?id=<?= $event['id'] ?>" class="btn btn-warning">Edit</a>
            <a href="event-cancel.php?id=<?= $event['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this event?')">Cancel Event</a>
            <a href="event-delete.php?id=<?= $event['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
        </div>
        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
