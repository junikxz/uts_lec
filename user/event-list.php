<?php
session_start();
require '../config/db.php';

// Fetch all events that are available (not full)
$event = $pdo->query("
    SELECT e.*, COUNT(r.id) AS total_registered 
    FROM event e
    LEFT JOIN registrations r ON e.id = r.event_id
    GROUP BY e.id
    HAVING total_registered < e.max_participants
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .navbar {
            background-color: #3a3a91;
        }
        .navbar-brand {
            color: white;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 200px;
            object-fit: cover;
        }
        .btn-primary {
            background-color: #3a3a91;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2a2a6f;
        }
        .event-info {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Event List</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Available Events</h1>
        <div class="row">
            <?php if (count($event) > 0): ?>
                <?php foreach ($event as $event): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" class="card-img-top" alt="Event Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($event['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                                <div class="event-info">
                                    <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                                    <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                                </div>
                                <a href="event-detail.php?id=<?= $event['id'] ?>" class="btn btn-primary">View Details & Register</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No events available.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
