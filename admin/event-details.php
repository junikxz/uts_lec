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
    <style>
        body {
            background-color: #3a3a91;
        }
        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
            width: 75%;
        }
        .btn-warning {
            background-color: #3a3a91;
            border-color: #3a3a91;
            color: #fff;
        }
        .btn-warning:hover {
            background-color: #2d2d75;
            border-color: #2d2d75;
            color: lightblue;
        }
        .table {
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #3a3a91;
            color: white;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Event: <?= htmlspecialchars($event['name']) ?></h1>
        <p><strong>Description:</strong> <?= htmlspecialchars($event['description']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
        <p><strong>Time:</strong> <?= htmlspecialchars($event['time']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
        <p><strong>Max Participants:</strong> <?= htmlspecialchars($event['max_participants']) ?></p>

        <div class="table-container">
            <h3>Registrants</h3>
            <?php if (count($registrant_list) > 0): ?>
                <table class="table table-striped mt-3">
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
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="event-edit.php?id=<?= $event['id'] ?>" class="btn btn-warning">Edit Event</a>
            <a href="event-cancel.php?id=<?= $event['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this event?')">Cancel Event</a>
            <a href="event-delete.php?id=<?= $event['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete Event</a>
        </div>
        <a href="dashboard.php" class="btn btn-secondary mt-4">Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
