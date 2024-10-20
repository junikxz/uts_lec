<?php
require '../config/db.php';

$events = $pdo->query("SELECT * FROM event WHERE status = 'open'")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $selected_events = $_POST['event']; 

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $password])) {
            $user_id = $pdo->lastInsertId();

            if (is_array($selected_events) && count($selected_events) > 0) {
                foreach ($selected_events as $event_id) {
                    $stmt_registration = $pdo->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
                    $stmt_registration->execute([$user_id, $event_id]);
                }
            }

            $pdo->commit();
            header("Location: login.php?success=1");
            exit();
        } else {
            $pdo->rollBack();
            echo "Error registering!";
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">Register</div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                            
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
