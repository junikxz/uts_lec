<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$today = date('Y-m-d');

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$filterStatus = isset($_GET['status']) ? $_GET['status'] : 'all';

$sql = "
    SELECT event.*, COUNT(registrations.user_id) AS participants_count
    FROM event
    LEFT JOIN registrations ON event.id = registrations.event_id
    WHERE event.name LIKE :search
";

if ($filterStatus == 'open') {
    $sql .= " AND date >= '$today' AND status = 'open'";
} elseif ($filterStatus == 'closed') {
    $sql .= " AND date < '$today' AND status = 'closed'";
} elseif ($filterStatus == 'cancelled') {
    $sql .= " AND status = 'canceled'";
}

$sql .= " GROUP BY event.id";

if ($filterStatus == 'all') {
    $sql .= " ORDER BY 
                CASE 
                    WHEN status = 'open' THEN 1 
                    WHEN status = 'closed' THEN 2
                    WHEN status = 'canceled' THEN 3
                END, date ASC";
} else {
    $sql .= " ORDER BY date ASC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute(['search' => "%$searchQuery%"]);
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css">
    <style>
        body {
            background-color: #f5f7fa;
        }

        .header-title {
            position: relative;
            max-width: 100%;
            aspect-ratio: 16 / 9;
            background-image: url('Header.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            z-index: 1;
        }

        .header-title h1 {
            font-size: 4rem;
            font-weight: bold;
        }

        .header-title p {
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .header-title h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 992px) {
            .header-title h1 {
                font-size: 3rem;
            }
        }

        @media (max-width: 468px) {
            .header-title h1 {
                font-size: 1.5rem;
            }
        }

        .header-form {
            color: #3a3a91;
        }

        .event-card {
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .event-card:hover {
            transform: scale(1.05);
        }

        .event-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .event-body {
            padding: 15px;
        }

        .event-footer {
            padding: 10px 15px;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .bg-light {
            background-color: lightgray !important;
        }

        .bg-primary {
            background-color: #3a3a91 !important;
        }

        .text-white {
            color: white !important;
        }

        .text-dark {
            color: black !important;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="header-title ">
        <div>
            <h1>Welcome to the Admin Dashboard</h1>
            <a href="#manage-events" class="btn btn-light mt-3" id="scrollButton">Click Here</a>
        </div>
    </div>

    <div class="container mt-5" id="manage-events">
        <div class="header-form text-center mt-4">
            <h1>Search Your Event</h1>
            <form method="GET" class="d-flex justify-content-center mt-3">
                <input type="text" name="search" class="form-control w-50" placeholder="Name of event" value="<?= htmlspecialchars($searchQuery) ?>">
                <select name="status" class="form-control mx-2">
                    <option value="all" <?= $filterStatus == 'all' ? 'selected' : '' ?>>All Status</option>
                    <option value="open" <?= $filterStatus == 'open' ? 'selected' : '' ?>>Open</option>
                    <option value="closed" <?= $filterStatus == 'closed' ? 'selected' : '' ?>>Closed</option>
                    <option value="cancelled" <?= $filterStatus == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="row mt-5">
            <?php if (empty($events)): ?>
                <h3 class="text-center mb-5">No events found.</h3>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <?php
                    $cardClass = '';
                    if ($event['status'] == 'canceled') {
                        $cardClass = 'bg-danger text-white';
                    } elseif ($event['status'] == 'closed') {
                        $cardClass = 'bg-light text-dark';
                    } elseif ($event['status'] == 'open') {
                        $cardClass = 'bg-primary text-white';
                    }

                    $maxParticipants = $event['max_participants'];
                    $participantsCount = $event['participants_count'];
                    $percentage = ($maxParticipants > 0) ? round(($participantsCount / $maxParticipants) * 100) : 0;
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="event-card <?= $cardClass ?>">
                            <img src="uploads/<?= htmlspecialchars($event['image']) ?>" class="event-image" alt="<?= htmlspecialchars($event['name']) ?>">
                            <div class="event-body">
                                <h5 class="event-title"><?= htmlspecialchars($event['name']) ?></h5>

                                <?php if ($event['status'] == 'open'): ?>
                                    <p class="text-white">This event is currently open for registration.</p>
                                <?php elseif ($event['status'] == 'closed'): ?>
                                    <p class="text-dark">This event is closed. Registration is no longer available.</p>
                                <?php elseif ($event['status'] == 'canceled'): ?>
                                    <p class="text-white">This event has been canceled.</p>
                                <?php endif; ?>
                            </div>
                            <div class="event-footer">
                                <strong>Date: <?= htmlspecialchars($event['date']) ?></strong><br>
                                <strong>Time: <?= htmlspecialchars($event['time']) ?></strong><br>
                                <strong>Location: <?= htmlspecialchars($event['location']) ?></strong>
                                <br />
                                <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-light mt-2">View Details</a>

                                <div class="mt-3">
                                    <label for="participants">Participants (<?= $participantsCount ?>/<?= $maxParticipants ?>)</label>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%;" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?= $percentage ?>%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
