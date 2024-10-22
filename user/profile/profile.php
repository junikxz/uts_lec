<?php
session_start();
require '../../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = $pdo->prepare("SELECT * FROM user WHERE id = ?");
$user->execute([$user_id]);
$user_info = $user->fetch(PDO::FETCH_ASSOC);

$registrations = $pdo->prepare("
    SELECT e.name, e.date, e.location 
    FROM registrations r
    JOIN event e ON r.event_id = e.id
    WHERE r.user_id = ?
");
$registrations->execute([$user_id]);
$events = $registrations->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success">
            Profil berhasil diupdate!
        </div>
    <?php endif; ?>

    <div class="container profile-container">
        <div class="left-panel">
            <img src="./path/to/profile-pic.jpg" alt="Profile Picture" class="profile-pic">
            <h4><?= htmlspecialchars($user_info['name']) ?></h4>
            <p><?= htmlspecialchars($user_info['email']) ?></p>
            <a href="edit-profile.php" class="btn btn-primary mt-4">Edit Profile</a>
        </div>

        <div class="right-panel">
            <h3>Histori Event yang Pernah Diikuti</h3>

            <?php if (count($events) > 0): ?>
                <ul class="list-group mt-3">
                    <?php foreach ($events as $event): ?>
                        <li class="list-group-item">
                            <strong><?= htmlspecialchars($event['name']) ?></strong><br>
                            Tanggal: <?= htmlspecialchars($event['date']) ?><br>
                            Lokasi: <?= htmlspecialchars($event['location']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="mt-3">Belum ada event yang diikuti.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>