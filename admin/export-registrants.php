<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$event_id = $_GET['id'];

// Fetch registrants for this event
$registrants = $pdo->prepare("SELECT * FROM registrations WHERE event_id = ?");
$registrants->execute([$event_id]);
$registrant_list = $registrants->fetchAll();

// Set header for CSV file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=registrants.csv');

// Create a file pointer
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, array('Name', 'Additional Info', 'Registration Date'));

// Output each row
foreach ($registrant_list as $registrant) {
    fputcsv($output, array($registrant['name'], $registrant['additional_info'], $registrant['registration_date']));
}

fclose($output);
exit();
?>
