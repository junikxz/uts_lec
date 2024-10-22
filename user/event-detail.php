<?php
// session_start();
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// require '../config/db.php';

// $events = $pdo->query("SELECT * FROM event WHERE status = 'open'")->fetchAll();

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $user_id = $_SESSION['user_id'];
//     $selected_events = isset($_POST['event']) ? $_POST['event'] : []; 

//     $userCheck = $pdo->prepare("SELECT id FROM user WHERE id = ?"); 
//     $userCheck->execute([$user_id]);

//     if ($userCheck->rowCount() === 0) {
//         echo "<div class='alert alert-danger'>User ID is invalid!</div>";
//         exit();
//     }

//     try {
//         $pdo->beginTransaction();

//         foreach ($selected_events as $event_id) {
//             $eventCheck = $pdo->prepare("SELECT id FROM event WHERE id = ?");
//             $eventCheck->execute([$event_id]);
        
//             if ($eventCheck->rowCount() > 0) {
//                 $stmt_registration = $pdo->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
//                 if (!$stmt_registration->execute([$user_id, $event_id])) {
//                     echo "Failed to register for event ID: $event_id<br>";
//                 }
//             } else {
//                 echo "Event ID $event_id does not exist!<br>";
//             }
//         }
        
//         $pdo->commit();
//         echo "<div class='alert alert-success'>You have successfully registered for the selected events!</div>";
        
//         $pdo->commit();
//         echo "<div class='alert alert-success'>You have successfully registered for the selected events!</div>";
//     } catch (Exception $e) {
//         $pdo->rollBack();
//         echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">Register for Events</div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="events" class="form-label">Select Events</label>
                                <div>
                                    <?php foreach ($events as $event): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="event[]" value="<?= $event['id'] ?>" id="event-<?= $event['id'] ?>">
                                            <label class="form-check-label" for="event-<?= $event['id'] ?>">
                                                <?= htmlspecialchars($event['name']) ?> (<?= htmlspecialchars($event['date']) ?>)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="event[]" value="<?= $event['id'] ?>" id="event-<?= $event['id'] ?>">
                                            <label class="form-check-label" for="event-<?= $event['id'] ?>">
                                                <?= htmlspecialchars($event['name']) ?> (<?= htmlspecialchars($event['date']) ?>)
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
