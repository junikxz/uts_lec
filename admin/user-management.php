<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$stmt = $pdo->query("
    SELECT u.id AS user_id, u.name, u.email, GROUP_CONCAT(e.name SEPARATOR ', ') AS events
    FROM user u
    LEFT JOIN registrations r ON u.id = r.user_id
    LEFT JOIN event e ON r.event_id = e.id
    GROUP BY u.id
");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .header-title {
            position: relative;
            max-width: 100%;
            aspect-ratio: 16 / 9;
            background-image: url('Header.png'); 
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            z-index: 1;
            padding: 20px;
        }
        .header-title h1 {
            font-size: 4rem;
            font-weight: bold;
        }
        .header-title p {
            font-size: 1.2rem;
        }
        @media (max-width:768px){
            .header-title h1 {
                font-size: 2rem;
            }
        }
        @media (max-width:992px){
            .header-title h1 {
                font-size: 3rem;
            }
        }
        @media (max-width:468px){
            .header-title h1 {
                font-size: 1.5rem;
            }
        }
        .table-container {
            margin: 20px auto;
            max-width: 90%;
        }
        .table {
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #3a3a91;
            color: white;
        }
        .table th, .table td {
            vertical-align: middle;
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

<div class="container mt-5 table-container">
    <div>
        <h1>Manage Users</h1>
        <p>View and manage registered users for events</p>
    </div>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Events Registered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['events'] ?: 'No events registered') ?></td>
                    <td>
                        <a href="delete-user.php?id=<?= $user['user_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
