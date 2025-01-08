<?php
session_start();
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_id = $_POST['menu_id'];
    $customization_detail = $_POST['customization_detail'];
    $sale_date = $_POST['sale_date'];
    $total_price = $_POST['total_price'];

    $stmt = $conn->prepare("INSERT INTO sales (menu_id, customization_detail, sale_date, total_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issd", $menu_id, $customization_detail, $sale_date, $total_price);
    if ($stmt->execute()) {
        header("Location: data_penjualan.php?success=Sale added successfully");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sale</title>
</head>
<body>
    <h1>Add Sale</h1>
    <form method="POST" action="add_sale.php">
        <label for="menu_id">Menu ID:</label>
        <input type="number" name="menu_id" id="menu_id" required><br>

        <label for="customization_detail">Customization Details:</label>
        <input type="text" name="customization_detail" id="customization_detail" required><br>

        <label for="sale_date">Sale Date:</label>
        <input type="date" name="sale_date" id="sale_date" required><br>

        <label for="total_price">Total Price:</label>
        <input type="number" name="total_price" id="total_price" step="0.01" required><br>

        <button type="submit">Add Sale</button>
    </form>
</body>
</html>
