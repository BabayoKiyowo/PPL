<?php
$servername = "localhost"; // Host database Anda
$username = "root"; // Username database Anda
$password = ""; // Password database Anda
$dbname = "coffee_shop"; // Nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "INSERT INTO orders (item_name, quantity, price, customization, total_price) 
        VALUES ('$item_name', $quantity, $price, '$customization', $total_price)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Order saved successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error]);
}
// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
