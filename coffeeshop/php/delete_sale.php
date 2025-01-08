<?php
session_start();
include 'db_conn.php';

if (isset($_GET['id'])) {
    $sale_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM sales WHERE id = ?");
    $stmt->bind_param("i", $sale_id);
    if ($stmt->execute()) {
        header("Location: data_penjualan.php?success=Sale deleted successfully");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
