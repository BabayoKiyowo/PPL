<?php
session_start();
include 'db_conn.php'; // Ensure this file contains the MySQLi connection logic

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
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>Navigation</h2>
        <a href="../php/data_penjualan.php">Data Penjualan</a>
        <a href="../php/data_menu.php">Data Menu</a>
        <a href="../php/data_pesanan.php">Data Pesanan</a>
        <a href="../php/admin_dashboard.php">Data Keseluruhan</a>
        <a href="../php/user.php" class="user">User</a>
        <a href="../php/logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <h1>Admin Dashboard</h1>
        <p>Welcome, Admin!</p>

        <!-- Tombol Ekspor -->
        <div class="export-buttons">
            <form method="POST" action="">
                <button type="submit" name="export_excel" class="button-export">Export to Excel</button>
                <button type="submit" name="export_pdf" class="button-export">Export to PDF</button>
            </form>
        </div>

        <!-- Data Penjualan -->
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

        <!-- Data Menu -->
        <h2>Data Menu</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Menu</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>URL Gambar</th>
                    <th>Detail Kustomisasi</th>
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

        <!-- Data Pesanan -->
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
