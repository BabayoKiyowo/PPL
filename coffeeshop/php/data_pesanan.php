<?php
session_start();
include 'db_conn.php'; // Pastikan file ini berisi koneksi ke database

// Fetch orders data
$queryOrders = "SELECT o.id, o.total_price, o.created_at, od.menu_id, od.quantity, od.price, m.name_ AS menu_name 
                FROM orders o 
                JOIN order_details od ON o.id = od.order_id 
                JOIN menu m ON od.menu_id = m.id";
$resultOrders = $conn->query($queryOrders);
$orders = $resultOrders->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { display: inline-block; margin-top: 20px; padding: 10px 15px; background-color: #5cb85c; color: white; text-decoration: none; border-radius: 5px; }
        a:hover { background-color: #4cae4c; }
    </style>
</head>
<body>
    <h1>Data Pesanan</h1>
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Total Harga</th>
                <th>Tanggal Dibuat</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']); ?></td>
                    <td><?= htmlspecialchars($order['total_price']); ?></td>
                    <td><?= htmlspecialchars($order['created_at']); ?></td>
                    <td><?= htmlspecialchars($order['menu_name']); ?></td>
                    <td><?= htmlspecialchars($order['quantity']); ?></td>
                    <td><?= htmlspecialchars($order['price']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../html/home.html">Kembali ke Home</a>
</body>
</html>
