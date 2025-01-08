<?php
session_start();
include 'db_conn.php'; // Ensure this file contains the MySQLi connection logic

// Check if the user is logged in and has the admin role

// Check if the 'admin' table exists

// Fetch sales data
$querySales = "SELECT s.id, m.name_ AS menu_name, s.customization_detail, s.sale_date, s.total_price 
               FROM sales s 
               JOIN menu m ON s.menu_id = m.id";
$resultSales = $conn->query($querySales);
$sales = $resultSales->fetch_all(MYSQLI_ASSOC);

// Fetch menu data
$queryMenu = "SELECT * FROM menu";
$resultMenu = $conn->query($queryMenu);
$menu = $resultMenu->fetch_all(MYSQLI_ASSOC);

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
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #5cb85c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, Admin!</p>

    <h2>Data Penjualan</h2>
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

    <h2>Data Menu</h2>
    <table>
        <thead>
            <tr>
                <th>ID Menu</th>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>URL Gambar</th>
                <th> Detail Kustomisasi</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menu as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['id']); ?></td>
                    <td><?= htmlspecialchars($item['name_']); ?></td>
                    <td><?= htmlspecialchars($item['price']); ?></td>
                    <td><?= htmlspecialchars($item['image_url']); ?></td>
                    <td><?= htmlspecialchars($item['customization']); ?></td>
                    <td><?= htmlspecialchars($item['category']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Data Pesanan</h2>
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


                    <td>
    <a href="update_sale.php?id=<?= htmlspecialchars($sale['id']); ?>">Edit</a>
    <a href="delete_sale.php?id=<?= htmlspecialchars($sale['id']); ?>" onclick="return confirm('Are you sure you want to delete this sale?');">Delete</a>
</td>
<a href="add_sale.php">Add New Sale</a>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="logout.php">Logout</a>
</body>
</html>