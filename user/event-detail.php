<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require '../config/db.php';

// Fetch all open events
$events = $pdo->query("SELECT * FROM event WHERE status = 'open'")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $selected_events = isset($_POST['event']) ? $_POST['event'] : [];

    $userCheck = $pdo->prepare("SELECT id FROM user WHERE id = ?");
    $userCheck->execute([$user_id]);

    if ($userCheck->rowCount() === 0) {
        echo "<div class='alert alert-danger'>User ID is invalid!</div>";
        exit();
    }

    try {
        $pdo->beginTransaction();

        foreach ($selected_events as $event_id) {
            $eventCheck = $pdo->prepare("SELECT id FROM event WHERE id = ?");
            $eventCheck->execute([$event_id]);

            if ($eventCheck->rowCount() > 0) {
                $stmt_registration = $pdo->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
                if (!$stmt_registration->execute([$user_id, $event_id])) {
                    echo "Failed to register for event ID: $event_id<br>";
                }
            } else {
                echo "Event ID $event_id does not exist!<br>";
            }
        }

        $pdo->commit();
        echo "<div class='alert alert-success'>You have successfully registered for the selected events!</div>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .event-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .event-details {
            display: flex;
            justify-content: space-between;
            gap: 30px;
        }
        .left-section {
            flex: 3;
        }
        .right-section {
            flex: 1;
        }
        .event-image {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .register-btn {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <?php foreach ($events as $event): ?>
            <div class="card mb-5">
                <div class="card-header bg-primary text-white">
                    <h2 class="event-title"><?= htmlspecialchars($event['name']) ?></h2>
                </div>
                <div class="card-body">
                    <div class="event-details">
                        <!-- Left Section: Image and Description -->
                        <div class="left-section">
                            <img src="<?= htmlspecialchars($event['image_url']) ?>" alt="Event Image" class="event-image">
                            <p><?= htmlspecialchars($event['description']) ?></p>
                        </div>

                        <!-- Right Section: Date and Location -->
                        <div class="right-section">
                            <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                            <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <div class="register-btn">
                        <form method="POST">
                            <input type="hidden" name="event[]" value="<?= $event['id'] ?>">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
