<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include '../database/db_config.php';

// Ambil laporan penjualan
$sales_sql = "SELECT * FROM sales ORDER BY sale_date DESC";
$sales_result = $conn->query($sales_sql);

// Ambil menu untuk ditampilkan dan diperbarui
$menu_sql = "SELECT * FROM menu";
$menu_result = $conn->query($menu_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

</head>
<body>
    <h2>Selamat Datang, <?php echo $_SESSION['admin_name']; ?></h2>
    <a href="logout.php">Logout</a>

    <h3>Laporan Penjualan</h3>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Menu</th>
            <th>Harga</th>
            <th>Detail Kustomisasi</th>
            <th>Total Harga</th>
            <th>Tanggal Penjualan</th>
        </tr>
        <?php
        $i = 1;
        while ($row = $sales_result->fetch_assoc()) {
            echo "<tr>
                    <td>{$i}</td>
                    <td>{$row['menu_name']}</td>
                    <td>Rp {$row['base_price']}</td>
                    <td>{$row['customization_detail']}</td>
                    <td>Rp {$row['total_price']}</td>
                    <td>{$row['sale_date']}</td>
                </tr>";
            $i++;
        }
        ?>
    </table>

    <h3>Daftar Menu</h3>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama Menu</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>
        <?php
        $i = 1;
        while ($row = $menu_result->fetch_assoc()) {
            echo "<tr>
                    <td>{$i}</td>
                    <td>{$row['name_']}</td>
                    <td>Rp {$row['price']}</td>
                    <td>{$row['category']}</td>
                    <td><a href='update_menu.php?id={$row['id']}'>Update</a></td>
                </tr>";
            $i++;
        }
        ?>
    </table>
</body>
</html>
