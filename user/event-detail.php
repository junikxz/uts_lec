<?php
require '../config/db.php';

$events = $pdo->query("SELECT * FROM event WHERE status = 'open'")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name']; 
    $additional_info = $_POST['additional_info'];
    $selected_events = $_POST['event']; 

    try {
        $pdo->beginTransaction();

        if (is_array($selected_events) && count($selected_events) > 0) {
            foreach ($selected_events as $event_id) {
                $stmt_registration = $pdo->prepare("INSERT INTO registrations (user_id, event_id, user_name, additional_info, created_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt_registration->execute([null, $event_id, $name, $additional_info]); 
            }
        }

        $pdo->commit();
        echo "<div class='alert alert-success'>You have successfully registered for the selected events!</div>";
        exit();
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
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="additional_info" class="form-label">Additional Info</label>
                                <textarea name="additional_info" class="form-control" id="additional_info"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Select Events</label>
                                <div>
                                    <?php foreach ($events as $event): ?>
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
