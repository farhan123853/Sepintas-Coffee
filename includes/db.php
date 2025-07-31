<?php
// Database connection for Sepintas Coffee
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'sepintas_coffee';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
