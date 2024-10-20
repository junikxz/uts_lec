<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$event_id = $_GET['id'];

$registrants = $pdo->prepare("SELECT * FROM registrations WHERE event_id = ?");
$registrants->execute([$event_id]);
$registrant_list = $registrants->fetchAll();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=registrants.csv');

$output = fopen('php://output', 'w');

fputcsv($output, array('Name', 'Additional Info', 'Registration Date'));

foreach ($registrant_list as $registrant) {
    fputcsv($output, array($registrant['name'], $registrant['additional_info'], $registrant['registration_date']));
}

fclose($output);
exit();
?>
