<?php
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

define('ROOT_URL', $root);
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'hPRGOHf6D3p3kWJF');
define('DB_NAME', 'fintelo_attendance');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($mysqli === false) {
    // IMPROVE ERROR HANDLING
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

session_start();

?>