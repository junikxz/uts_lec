<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $location = htmlspecialchars($_POST['location']);
    $max_participants = htmlspecialchars($_POST['max_participants']);
    $status = $_POST['status'];

    $target_dir = "uploads/"; 
    $image = basename($_FILES["image"]["name"]); 

    if (!empty($image)) {
        $target_file = $target_dir . $image;
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO event (name, description, date, time, location, max_participants, status, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$name, $description, $date, $time, $location, $max_participants, $status, $image])) {
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error creating event!</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error: Gagal mengunggah file.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error: Nama file gambar kosong.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link rel="stylesheet" href="navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #3a3a91;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #3a3a91;
            font-weight: bold;
        }
        label {
            color: #555;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #3a3a91;
            border-color: #3a3a91;
        }
        .btn-primary:hover {
            background-color: blue;
            border-color: blue;
            color: white;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>


<div class="container mt-5">
    <div class="form-container">
        <h1>Create Event</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Event Name</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" rows="4" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" id="date" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="time" class="form-label">Time</label>
                    <input type="time" name="time" class="form-control" id="time" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" class="form-control" id="location" required>
            </div>
            <div class="mb-3">
                <label for="max_participants" class="form-label">Max Participants</label>
                <input type="number" name="max_participants" class="form-control" id="max_participants" min='0' required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" id="status" required>
                    <option value="open">Open</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Event Image</label>
                <input type="file" name="image" class="form-control" id="image" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Create Event</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
