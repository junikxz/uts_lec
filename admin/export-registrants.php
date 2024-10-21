<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../user/login.php');
    exit();
}

require '../config/db.php';

$events = $pdo->query("
    SELECT DISTINCT e.id, e.name AS event_name 
    FROM event e
    JOIN registrations r ON e.id = r.event_id
")->fetchAll(PDO::FETCH_ASSOC);

if (empty($events)) {
    echo "No events with registrants found.";
    exit();
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=registrants_per_event.csv');

$output = fopen('php://output', 'w');

foreach ($events as $event) {
    fputcsv($output, array($event['event_name'])); 
    
    fputcsv($output, array('User Name', 'Email', 'Registration Date'));

    $registrants = $pdo->prepare("
        SELECT u.username AS name, u.email, r.created_at
        FROM registrations r
        JOIN user u ON r.user_id = u.id
        WHERE r.event_id = ?
    ");
    $registrants->execute([$event['id']]);
    $registrant_list = $registrants->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($registrant_list as $registrant) {
        fputcsv($output, array(
            $registrant['name'],     
            $registrant['email'],    
            $registrant['created_at'] 
        ));
    }
    
    fputcsv($output, array()); 
}

fclose($output);
exit();
?>
