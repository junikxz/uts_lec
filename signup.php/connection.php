<?php
// Example connection using PDO
$host = 'localhost';
$db = 'nama_database'; // Ganti dengan nama database Anda
$user = 'root'; // Ganti dengan username database
$pass = ''; // Ganti dengan password database

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
