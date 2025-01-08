<?php
$host = 'localhost'; // Perbaiki nama variabel dari $username ke $host
$username = 'root'; // Ganti sesuai username database Anda, biasanya 'root' untuk lokal
$password = ''; // Biarkan kosong jika Anda tidak menggunakan password untuk root
$database = 'coffee_shop'; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful!";
}
?>
