<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM event WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $max_participants = $_POST['max_participants'];
    $status = $_POST['status']; 

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    } else {
        $image = $event['image'];
    }

    $stmt = $pdo->prepare("UPDATE event SET name = ?, description = ?, date = ?, location = ?, max_participants = ?, image = ?, status = ? WHERE id = ?");
    if ($stmt->execute([$name, $description, $date, $location, $max_participants, $image, $status, $id])) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating event!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #3a3a91;
        }
        .form-label {
            color: #333;
        }
        .btn-primary {
            background-color: #3a3a91;
            border-color: #3a3a91;
        }
        .btn-primary:hover {
            background-color: #2d2d75;
            border-color: #2d2d75;
        }
        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }
        h1 {
            color: #3a3a91;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .mb-3 img {
            margin-top: 10px;
            max-width: 100px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Event</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Event Name</label>
                <input type="text" name="name" class="form-control" id="name" value="<?= htmlspecialchars($event['name']) ?>" required>
            </div>
            <div class="mb-3">

            <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" rows="4" required><?= htmlspecialchars($event['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" id="date" value="<?= $event['date'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Time</label>
                <input type="time" name="time" class="form-control" id="time" value="<?= $event['time'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" class="form-control" id="location" value="<?= htmlspecialchars($event['location']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="max_participants" class="form-label">Max Participants</label>
                <input type="number" name="max_participants" class="form-control" id="max_participants" value="<?= $event['max_participants'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" id="status" required>
                    <option value="open" <?= $event['status'] == 'open' ? 'selected' : '' ?>>Open</option>
                    <option value="closed" <?= $event['status'] == 'closed' ? 'selected' : '' ?>>Closed</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Event Image</label>
                <input type="file" name="image" class="form-control" id="image" accept="image/*">
                <small class="text-muted">Current Image:</small> 
                <img src="uploads/<?= htmlspecialchars($event['image']) ?>" alt="Event Image">
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Update Event</button>
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
