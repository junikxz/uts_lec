<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$today = date('Y-m-d');

$openEvents = $pdo->query("
    SELECT event.*, COUNT(registrations.user_id) AS participants_count
    FROM event
    LEFT JOIN registrations ON event.id = registrations.event_id
    WHERE date >= '$today' AND status = 'open'
    GROUP BY event.id
")->fetchAll();

$closedEvents = $pdo->query("
    SELECT event.*, COUNT(registrations.user_id) AS participants_count
    FROM event
    LEFT JOIN registrations ON event.id = registrations.event_id
    WHERE date < '$today' AND status = 'closed'
    GROUP BY event.id
")->fetchAll();

$cancelledEvents = $pdo->query("
    SELECT event.*, COUNT(registrations.user_id) AS participants_count
    FROM event
    LEFT JOIN registrations ON event.id = registrations.event_id
    WHERE status = 'canceled'
    GROUP BY event.id
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand {
            color: white;
        }
        .side-menu {
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            height: 100%;
            background-color: #343a40;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .side-menu ul {
            list-style: none;
            padding: 0;
        }
        .side-menu ul li {
            padding: 20px;
            border-bottom: 1px solid #464a4d;
        }
        .side-menu ul li a {
            color: white;
            text-decoration: none;
        }
        .side-menu ul li:hover {
            background-color: #495057;
        }
        .side-menu.open {
            left: 0;
        }
        .menu-icon {
            font-size: 30px;
            cursor: pointer;
            color: white;
        }
        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 999;
            display: none;
        }
        .overlay.show {
            display: block;
        }
        .submenu {
            display: none;
        }
        .submenu li {
            padding-left: 20px;
            background-color: #495057;
        }
        .submenu.open {
            display: block;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
            <a class="navbar-brand ms-3" href="#">Admin Dashboard</a>
        </div>
    </nav>

    <div class="side-menu" id="sideMenu">
        <ul>
            <li>
                <a href="javascript:void(0)" onclick="toggleSubmenu()">Dashboard</a>
                <ul class="submenu" id="submenu">
                    <li><a href="dashboard.php">View All Events</a></li>
                    <li><a href="event-create.php">Create Event</a></li>
                </ul>
            </li>
            <li><a href="user-management.php">Registrants List</a></li>
        </ul>
    </div>

    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <div class="container mt-5">
        <h1>Manage Events</h1>
        
        <h2>Open Events</h2>
        <h2>Open Events</h2>
<div class="row">
    <?php if (empty($openEvents)): ?>
        <p>No open events available.</p>
    <?php else: ?>
        <?php foreach ($openEvents as $event): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($event['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($event['name']) ?></h5>
                        <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                        <p><strong>Time:</strong> <?= htmlspecialchars($event['time']) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                        <p><strong>Participants:</strong> <?= htmlspecialchars($event['participants_count']) ?></p>
                        <div class="d-flex justify-content-between">
                            <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-primary">See Details</a>
                            <a href="cancel-event.php?id=<?= $event['id'] ?>" class="btn btn-danger">Cancel Event</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<h2>Closed Events</h2>
<div class="row">
    <?php if (empty($closedEvents)): ?>
        <p>No closed events available.</p>
    <?php else: ?>
        <?php foreach ($closedEvents as $event): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($event['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($event['name']) ?></h5>
                        <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                        <p><strong>Time:</strong> <?= htmlspecialchars($event['time']) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                        <p><strong>Participants:</strong> <?= htmlspecialchars($event['participants_count']) ?></p>
                        <div class="d-flex justify-content-between">
                            <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-secondary">See Details</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<h2>Cancelled Events</h2>
<div class="row">
    <?php if (empty($cancelledEvents)): ?>
        <p>No cancelled events available.</p>
    <?php else: ?>
        <?php foreach ($cancelledEvents as $event): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($event['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($event['name']) ?></h5>
                        <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                        <p><strong>Time:</strong> <?= htmlspecialchars($event['time']) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                        <p><strong>Participants:</strong> <?= htmlspecialchars($event['participants_count']) ?></p>
                        <div class="d-flex justify-content-between">
                            <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-danger">See Details</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


    <script>
        function toggleMenu() {
            document.getElementById('sideMenu').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('show');
        }
        function toggleSubmenu() {
            document.getElementById('submenu').classList.toggle('open');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
