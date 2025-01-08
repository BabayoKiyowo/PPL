<?php
$dbHost = 'localhost';
$dbUser   = 'root';
$dbPass = '';
$dbName = 'coffeeshop';

$db = new mysqli($dbHost, $dbUser  , $dbPass, $dbName);

if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

// Return the database connection
return $db;
?>