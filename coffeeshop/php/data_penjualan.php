<?php
session_start();
include 'db_conn.php'; // Pastikan file ini berisi koneksi ke database

// Fetch sales data
$querySales = "SELECT s.id, m.name_ AS menu_name, s.customization_detail, s.sale_date, s.total_price 
               FROM sales s 
               JOIN menu m ON s.menu_id = m.id";
$resultSales = $conn->query($querySales);
$sales = $resultSales->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan</title>
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
    <h1>Data Penjualan</h1>
    <table>
        <thead>
            <tr>
                <th>ID Penjualan</th>
                <th>Nama Menu</th>
                <th>Detail Kustomisasi</th>
                <th>Tanggal Penjualan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sales as $sale): ?>
                <tr>
                    <td><?= htmlspecialchars($sale['id']); ?></td>
                    <td><?= htmlspecialchars($sale['menu_name']); ?></td>
                    <td><?= htmlspecialchars($sale['customization_detail']); ?></td>
                    <td><?= htmlspecialchars($sale['sale_date']); ?></td>
                    <td><?= htmlspecialchars($sale['total_price']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../html/home.html">Kembali ke Home</a>
</body>
</html>
