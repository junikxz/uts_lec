<?php
session_start();
require '../../config/db.php'; 

$events = $pdo->query("
    SELECT e.*, COUNT(r.id) AS total_registered 
    FROM event e
    LEFT JOIN registrations r ON e.id = r.event_id
    GROUP BY e.id
    HAVING total_registered < e.max_participants
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="header">
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="homepage.php">
                    <img src="./asset/Logo.png" alt="Logo" height="50">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="homepage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="informations.php">Informations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="profile.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="registered-events.php">Daftar Event</a></li>
                                <li><a class="dropdown-item" href="edit-profile.php">Edit Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="overlay">
            <div class="header-title text-center text-white mt-5">
                <h1>All Events on One Page</h1>
                <p>when you can search, register, and log all events more easily, why not?</p>
            </div>
        </div>
    </section>
    
    <section>
        <div class="header-form text-center mt-3">
            <h1 class="">Search Your Event</h1>
            <form class="d-flex justify-content-center mt-3">
                <input type="text" class="form-control w-50" placeholder="Name of event">
                <button type="submit" class="btn btn-primary ms-2">Search</button>
            </form>
        </div>
    </section>

    <div class="container mt-5">
        <div class="row">
            <?php if (count($events) > 0): ?>
                <?php foreach ($events as $event): ?>
                    <div class="col-md-4 mb-4">
                        <div class="event-card">
                            <img src="../admin/uploads/<?= htmlspecialchars($event['image']) ?>" class="event-image" alt="Event Image">
                            <div class="event-body">
                                <h5 class="event-title"><?= htmlspecialchars($event['name']) ?></h5>
                                <p class="event-description"><?= htmlspecialchars($event['description']) ?></p>
                            </div>
                            <div class="event-footer">
                                <strong>Date: <?= htmlspecialchars($event['date']) ?></strong>
                                <strong>Time: <?= htmlspecialchars($event['time']) ?></strong>
                                <strong>Location: <?= htmlspecialchars($event['location']) ?></strong>
                                <a href="../event-detail.php?= $event['id'] ?>" class="btn btn-primary btn-register">View Details & Register</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h3 class="text-center mb-5">no events available.</h3>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
