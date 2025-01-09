<?php
session_start();
include 'db_conn.php'; // Koneksi ke database

// Tambahkan data
if (isset($_POST['add'])) {
    $menu_id = $_POST['menu_id'];
    $customization = $_POST['customization'];
    $sale_date = $_POST['sale_date'];
    $total_price = $_POST['total_price'];

    $query = "INSERT INTO sales (menu_id, customization_detail, sale_date, total_price) VALUES ('$menu_id', '$customization', '$sale_date', '$total_price')";
    $conn->query($query);
    header("Location: data_penjualan.php");
}

// Hapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM sales WHERE id = $id";
    $conn->query($query);
    header("Location: data_penjualan.php");
}

// Fetch data untuk ditampilkan
$querySales = "SELECT s.id, m.name_ AS menu_name, s.customization_detail, s.sale_date, s.total_price 
               FROM sales s 
               JOIN menu m ON s.menu_id = m.id";
$resultSales = $conn->query($querySales);
$sales = $resultSales->fetch_all(MYSQLI_ASSOC);

// Fungsi export Excel
if (isset($_POST['export_excel'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=data_penjualan.xls");
    echo "<table border='1'>";
    echo "<tr>
            <th>ID Penjualan</th>
            <th>Nama Menu</th>
            <th>Detail Kustomisasi</th>
            <th>Tanggal Penjualan</th>
            <th>Total Harga</th>
          </tr>";
    foreach ($sales as $sale) {
        echo "<tr>
                <td>{$sale['id']}</td>
                <td>{$sale['menu_name']}</td>
                <td>{$sale['customization_detail']}</td>
                <td>{$sale['sale_date']}</td>
                <td>{$sale['total_price']}</td>
              </tr>";
    }
    echo "</table>";
    exit();
}

// Fungsi export PDF
if (isset($_POST['export_pdf'])) {
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=data_penjualan.pdf");

    echo "<html><body>";
    echo "<h1>Data Penjualan</h1>";
    echo "<table border='1' style='width: 100%; border-collapse: collapse;'>";
    echo "<tr>
            <th>ID Penjualan</th>
            <th>Nama Menu</th>
            <th>Detail Kustomisasi</th>
            <th>Tanggal Penjualan</th>
            <th>Total Harga</th>
          </tr>";
    foreach ($sales as $sale) {
        echo "<tr>
                <td>{$sale['id']}</td>
                <td>{$sale['menu_name']}</td>
                <td>{$sale['customization_detail']}</td>
                <td>{$sale['sale_date']}</td>
                <td>{$sale['total_price']}</td>
              </tr>";
    }
    echo "</table>";
    echo "</body></html>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan</title>
    <link rel="stylesheet" href="../css/penjualan.css">
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
    <div class="container">
        <h1>Data Penjualan</h1>

        <!-- Form Tambah Data -->
        <form method="POST" class="crud-form">
            <input type="text" name="menu_id" placeholder="ID Menu" required>
            <input type="text" name="customization" placeholder="Detail Kustomisasi" required>
            <input type="date" name="sale_date" required>
            <input type="number" name="total_price" placeholder="Total Harga" required>
            <button type="submit" name="add">Tambah Data</button>
        </form>

        <!-- Tabel Data -->
        <table>
            <thead>
                <tr>
                    <th>ID Penjualan</th>
                    <th>Nama Menu</th>
                    <th>Detail Kustomisasi</th>
                    <th>Tanggal Penjualan</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
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
                        <td>
                            <a class="delete" href="?delete=<?= $sale['id']; ?>">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Tombol Ekspor -->
        <form method="POST" class="export-buttons">
            <button type="submit" name="export_excel">Export ke Excel</button>
            <button type="submit" name="export_pdf">Export ke PDF</button>
        </form>

        <a class="back-link" href="../html/home.html">Kembali ke Home</a>
    </div>
</body>
</html>
