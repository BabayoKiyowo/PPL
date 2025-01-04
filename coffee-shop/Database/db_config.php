<?php
$servername = "localhost";
$username = "root"; // Default username untuk XAMPP
$password = ""; // Default password kosong untuk XAMPP
$dbname = "coffee_shop"; // Nama database yang sudah Anda buat

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
