<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$event_id = $_GET['id']; // Ambil event ID

// Ambil detail event
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

// Ambil daftar pendaftar untuk event ini
$registrants = $pdo->prepare("
    SELECT u.name, u.email, r.registration_date 
    FROM registrations r
    JOIN users u ON r.user_id = u.id
    WHERE r.event_id = ?
");
$registrants->execute([$event_id]);
$registrant_list = $registrants->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registrants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Registrants for <?= htmlspecialchars($event['name']) ?></h1>
        <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>

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
                            <td><?= htmlspecialchars($registrant['name']) ?></td>
                            <td><?= htmlspecialchars($registrant['email']) ?></td>
                            <td><?= htmlspecialchars($registrant['registration_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No registrants for this event.</p>
        <?php endif; ?>

        <a href="dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
