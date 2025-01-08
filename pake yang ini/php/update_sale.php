<?php
session_start();
include 'db_conn.php';

if (isset($_GET['id'])) {
    $sale_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM sales WHERE id = ?");
    $stmt->bind_param("i", $sale_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $sale = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_id = $_POST['menu_id'];
    $customization_detail = $_POST['customization_detail'];
    $sale_date = $_POST['sale_date'];
    $total_price = $_POST['total_price'];

    $stmt = $conn->prepare("UPDATE sales SET menu_id = ?, customization_detail = ?, sale_date = ?, total_price = ? WHERE id = ?");
    $stmt->bind_param("issdi", $menu_id, $customization_detail, $sale_date, $total_price, $sale_id);
    if ($stmt->execute()) {
        header("Location: data_penjualan.php?success=Sale updated successfully");
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
    <title>Update Sale</title>
</head>
<body>
    <h1>Update Sale</h1>
    <form method="POST" action="update_sale.php?id=<?= $sale['id']; ?>">
        <label for="menu_id">Menu ID:</label>
        <input type="number" name="menu_id" id="menu_id" value="<?= $sale['menu_id']; ?>" required><br>

        <label for="customization_detail">Customization Details:</label>
        <input type="text" name="customization_detail" id="customization_detail" value="<?= $sale['customization_detail']; ?>" required><br>

        <label for="sale_date">Sale Date:</label>
        <input type="date" name="sale_date" id="sale_date" value="<?= $sale['sale_date']; ?>" required><br>

        <label for="total_price">Total Price:</label>
        <input type="number" name="total_price" id="total_price" value="<?= $sale['total_price']; ?>" step="0.01" required><br>

        <button type="submit">Update Sale</button>
    </form>
</body>
</html>
