<?php
session_start();
include 'db_conn.php'; // Pastikan file ini berisi koneksi ke database

// Tambah data menu
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $customization = $_POST['customization'];
    $category = $_POST['category'];

    $query = "INSERT INTO menu (name_, price, image_url, customization, category) 
              VALUES ('$name', '$price', '$image_url', '$customization', '$category')";
    $conn->query($query);
    header("Location: data_menu.php");
}

// Hapus data menu
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM menu WHERE id = $id";
    $conn->query($query);
    header("Location: data_menu.php");
}

// Fetch data menu
$queryMenu = "SELECT * FROM menu";
$resultMenu = $conn->query($queryMenu);
$menu = $resultMenu->fetch_all(MYSQLI_ASSOC);

// Fungsi export Excel
if (isset($_POST['export_excel'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=data_menu.xls");
    echo "<table border='1'>";
    echo "<tr>
            <th>ID Menu</th>
            <th>Nama Menu</th>
            <th>Harga</th>
            <th>URL Gambar</th>
            <th>Detail Kustomisasi</th>
            <th>Kategori</th>
          </tr>";
    foreach ($menu as $item) {
        echo "<tr>
                <td>{$item['id']}</td>
                <td>{$item['name_']}</td>
                <td>{$item['price']}</td>
                <td>{$item['image_url']}</td>
                <td>{$item['customization']}</td>
                <td>{$item['category']}</td>
              </tr>";
    }
    echo "</table>";
    exit();
}

// Fungsi export PDF
if (isset($_POST['export_pdf'])) {
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=data_menu.pdf");

    echo "<html><body>";
    echo "<h1>Data Menu</h1>";
    echo "<table border='1' style='width: 100%; border-collapse: collapse;'>";
    echo "<tr>
            <th>ID Menu</th>
            <th>Nama Menu</th>
            <th>Harga</th>
            <th>URL Gambar</th>
            <th>Detail Kustomisasi</th>
            <th>Kategori</th>
          </tr>";
    foreach ($menu as $item) {
        echo "<tr>
                <td>{$item['id']}</td>
                <td>{$item['name_']}</td>
                <td>{$item['price']}</td>
                <td>{$item['image_url']}</td>
                <td>{$item['customization']}</td>
                <td>{$item['category']}</td>
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
    <title>Data Menu</title>
    <link rel="stylesheet" href="../css/menu.css">
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
        <h1>Data Menu</h1>

        <!-- Form Tambah Data -->
        <form method="POST" class="crud-form">
            <input type="text" name="name" placeholder="Nama Menu" required>
            <input type="number" name="price" placeholder="Harga" required>
            <input type="text" name="image_url" placeholder="URL Gambar" required>
            <input type="text" name="customization" placeholder="Detail Kustomisasi" required>
            <input type="text" name="category" placeholder="Kategori" required>
            <button type="submit" name="add">Tambah Menu</button>
        </form>

        <!-- Tabel Data Menu -->
        <table>
            <thead>
                <tr>
                    <th>ID Menu</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>URL Gambar</th>
                    <th>Detail Kustomisasi</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
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
                        <td>
                            <a class="delete" href="?delete=<?= $item['id']; ?>">Hapus</a>
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
