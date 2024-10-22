<?php
session_start();
require '../config/db.php'; 

// Dapatkan ID event dari URL
if (!isset($_GET['id'])) {
    echo "No event ID provided!";
    exit();
}

$event_id = $_GET['id'];

// Query untuk mengambil detail acara berdasarkan ID event
$stmt = $pdo->prepare("SELECT * FROM event WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    echo "Event not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['name']) ?> - Event Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .event-detail {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .event-detail .left {
            flex: 1;
            max-width: 30%;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .event-detail .right {
            flex: 2;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .event-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .event-description {
            font-size: 16px;
            color: #333;
        }

        .event-info {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        .register-button {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container event-detail">
    <!-- Sisi kiri: Tanggal dan Tempat -->
    <div class="left">
        <h4>Event Info</h4>
        <div class="event-info">
            <strong>Date:</strong> <?= htmlspecialchars($event['date']) ?><br>
            <strong>Time:</strong> <?= htmlspecialchars($event['time']) ?><br>
            <strong>Location:</strong> <?= htmlspecialchars($event['location']) ?><br>
            <strong>Available Seats:</strong> <?= htmlspecialchars($event['max_participants']) ?><br>
        </div>
    </div>

    <!-- Sisi kanan: Gambar dan Deskripsi Event -->
    <div class="right">
        <h2 class="text-center"><?= htmlspecialchars($event['name']) ?></h2>
        <img src="../admin/uploads/<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['name']) ?>" class="event-image">
        
        <p class="event-description">
            <?= htmlspecialchars($event['description']) ?>
        </p>
        
        <a href="register.php?id=<?= $event['id'] ?>" class="btn btn-primary register-button">Register Now</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
