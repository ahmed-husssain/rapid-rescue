<?php
// Database connection configuration for Rapid Rescue.
$password = getenv('RAPID_RESCUE_DB_PASSWORD') ?: '';
$database = getenv('RAPID_RESCUE_DB_NAME') ?: 'ambulance';
$server = getenv('RAPID_RESCUE_DB_HOST') ?: 'localhost';
$username = getenv('RAPID_RESCUE_DB_USER') ?: 'root';

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection Error: ' . $conn->connect_error);
}

$conn->set_charset('utf8');
date_default_timezone_set('America/New_York');

// Demo credentials are supplied only by the deployment environment.
require_once __DIR__ . '/seed_demo_users.php';
?>
