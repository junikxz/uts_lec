<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $max_participants = $_POST['max_participants'];
    $status = $_POST['status'];

    // Atur direktori target untuk upload
    $target_dir = "uploads/"; // Sesuaikan dengan path yang benar
    $image = basename($_FILES["image"]["name"]); // Nama file gambar

    if (!empty($image)) {
        $target_file = $target_dir . $image; // Path lengkap file
        // Pindahkan file yang diunggah ke direktori target
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Siapkan dan jalankan pernyataan SQL untuk memasukkan data ke tabel event
            $sql = "INSERT INTO event (name, description, date, time, location, max_participants, status, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$name, $description, $date, $time, $location, $max_participants, $status, $image])) {
                // Pengalihan setelah berhasil
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Error creating event!";
            }
        } else {
            echo "Error: Gagal mengunggah file.";
        }
    } else {
        echo "Error: Nama file gambar kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create New Event</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Event Name</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" id="date" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Time</label>
                <input type="time" name="time" class="form-control" id="time" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" class="form-control" id="location" required>
            </div>
            <div class="mb-3">
                <label for="max_participants" class="form-label">Max Participants</label>
                <input type="number" name="max_participants" class="form-control" id="max_participants" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" id="status" required>
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Event Image</label>
                <input type="file" name="image" class="form-control" id="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Event</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>