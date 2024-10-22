<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

// Fetch events and their registration counts
$stmt = $pdo->query("
    SELECT event.id, event.name, COUNT(registrations.event_id) AS registrant_count 
    FROM event 
    LEFT JOIN registrations ON event.id = registrations.event_id 
    GROUP BY event.id
");
$events = $stmt->fetchAll();

if (!$events) {
    echo "<div class='alert alert-danger'>No events found!</div>";
    exit();
}

$event_names = [];
$event_counts = [];
foreach ($events as $event) {
    $event_names[] = $event['name'];
    $event_counts[] = (int) $event['registrant_count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Event Analytics</h1>
        <canvas id="eventChart" width="400" height="200"></canvas>
        
        <script>
            const ctx = document.getElementById('eventChart').getContext('2d');
            const eventChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($event_names) ?>,
                    datasets: [{
                        label: 'Number of Registrants',
                        data: <?= json_encode($event_counts) ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
