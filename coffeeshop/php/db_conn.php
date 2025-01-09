<?php
$servername = "localhost"; // Host database Anda
$username = "root"; // Username database Anda
$password = ""; // Password database Anda
$dbname = "coffee_shop"; // Nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
