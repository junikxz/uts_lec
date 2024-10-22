<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require '../config/db.php';

// Ambil event ID dari URL
$event_id = $_GET['id'] ?? null;
if ($event_id === null) {
    echo "<div class='alert alert-danger'>Event ID is missing!</div>";
    exit();
}

// Ambil detail event berdasarkan event_id
$stmt = $pdo->prepare("SELECT * FROM event WHERE id = ? AND status = 'open'");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    echo "<div class='alert alert-danger'>Event not found or it's closed!</div>";
    exit();
}

// Jika form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    try {
        $pdo->beginTransaction();

        // Periksa apakah event tersedia
        $eventCheck = $pdo->prepare("SELECT id FROM event WHERE id = ?");
        $eventCheck->execute([$event_id]);

        if ($eventCheck->rowCount() > 0) {
            // Insert data registrasi
            $stmt_registration = $pdo->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
            if ($stmt_registration->execute([$user_id, $event_id])) {
                echo "<div class='alert alert-success fixed-alert'>You have successfully registered for the event!</div>";
            } else {
                echo "<div class='alert alert-danger fixed-alert'>Failed to register for this event.</div>";
            }
        } else {
            echo "<div class='alert alert-danger fixed-alert'>Event does not exist!</div>";
        }

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<div class='alert alert-danger fixed-alert'>Error: " . $e->getMessage() . "</div>";
    }
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
            width: 50%;
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
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
        }

        /* Styles for fixed alert messages */
        .fixed-alert {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: auto;
            max-width: 80%;
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

            <form method="POST" class="register-button">
                <button type="submit" class="btn btn-primary">Register for This Event</button>
                <a href="homepage.php" class="btn btn-secondary">Back to Homepage</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
