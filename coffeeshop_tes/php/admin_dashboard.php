<?php
session_start();
include "db_conn.php";

// Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
    header("Location: admin_login.php");
    exit();
}

// Tentukan email admin yang diizinkan
$allowedAdminEmails = ['fadli@gmail.com', 'syalu@gmail.com']; // Ganti dengan email admin yang valid

// Cek apakah email user termasuk dalam daftar email admin yang diizinkan
if (!in_array($_SESSION['email'], $allowedAdminEmails)) {
    header("Location: admin_login.php"); // Atau tampilkan pesan error
    exit();
}

// Ambil data menu
$queryMenu = "SELECT id, name, base_price, customizations, image, category FROM catalog";
$resultMenu = $conn->query($queryMenu);
$menu = ($resultMenu) ? $resultMenu->fetch_all(MYSQLI_ASSOC) : [];

// Ambil data transaksi
$queryTransaksi = "SELECT t.id, t.total_price, t.created_at, 
                        td.menu_id, td.quantity, td.price, 
                        m.name AS menu_name
                    FROM transaksi t
                    JOIN transaksi_detail td ON t.id = td.transaksi_id
                    JOIN catalog m ON td.menu_id = m.id";
$resultTransaksi = $conn->query($queryTransaksi);
$transaksi = ($resultTransaksi) ? $resultTransaksi->fetch_all(MYSQLI_ASSOC) : [];

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
        h1, h2 {
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
        img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['name']); ?>!</p>

    <h2>Data Menu</h2>
    <table>
        <thead>
            <tr>
                <th>ID Menu</th>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Detail Kustomisasi</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($menu)): ?>
                <tr>
                    <td colspan="6">Tidak ada data menu.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($menu as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['id']); ?></td>
                        <td><?= htmlspecialchars($item['name']); ?></td>
                        <td><?= htmlspecialchars($item['base_price']); ?></td>
                        <td><img src="<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>"></td>
                        <td><?= htmlspecialchars($item['customizations']); ?></td>
                        <td><?= htmlspecialchars($item['category']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Data Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Total Harga</th>
                <th>Tanggal Dibuat</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($transaksi)): ?>
                <tr>
                    <td colspan="6">Tidak ada data transaksi.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($transaksi as $trx): ?>
                    <tr>
                        <td><?= htmlspecialchars($trx['id']); ?></td>
                        <td><?= htmlspecialchars($trx['total_price']); ?></td>
                        <td><?= htmlspecialchars($trx['created_at']); ?></td>
                        <td><?= htmlspecialchars($trx['menu_name']); ?></td>
                        <td><?= htmlspecialchars($trx['quantity']); ?></td>
                        <td><?= htmlspecialchars($trx['price']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="logout.php">Logout</a>
</body>
</html>
