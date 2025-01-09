<?php
session_start();
include 'db_conn.php'; // Pastikan file koneksi database Anda benar

// Tambah Pesanan
if (isset($_POST['add_order'])) {
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total_price = $quantity * $price;
    $created_at = date('Y-m-d H:i:s');

    $queryAddOrder = "INSERT INTO orders (total_price, created_at) VALUES ('$total_price', '$created_at')";
    if ($conn->query($queryAddOrder)) {
        $order_id = $conn->insert_id;
        $queryAddDetail = "INSERT INTO order_details (order_id, menu_id, quantity, price) VALUES ('$order_id', '$menu_id', '$quantity', '$price')";
        $conn->query($queryAddDetail);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Edit Pesanan
if (isset($_POST['edit_order'])) {
    $order_id = $_POST['order_id'];
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total_price = $quantity * $price;

    $queryEditOrder = "UPDATE orders SET total_price = '$total_price' WHERE id = '$order_id'";
    $queryEditDetail = "UPDATE order_details SET menu_id = '$menu_id', quantity = '$quantity', price = '$price' WHERE order_id = '$order_id'";
    $conn->query($queryEditOrder);
    $conn->query($queryEditDetail);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Hapus Pesanan
if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];

    $queryDeleteDetail = "DELETE FROM order_details WHERE order_id = '$order_id'";
    $queryDeleteOrder = "DELETE FROM orders WHERE id = '$order_id'";
    $conn->query($queryDeleteDetail);
    $conn->query($queryDeleteOrder);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch orders data
$queryOrders = "
    SELECT 
        o.id, o.total_price, o.created_at, 
        od.menu_id, od.quantity, od.price, 
        m.name_ AS menu_name 
    FROM 
        orders o 
    JOIN 
        order_details od ON o.id = od.order_id 
    JOIN 
        menu m ON od.menu_id = m.id";
$resultOrders = $conn->query($queryOrders);
$orders = $resultOrders->fetch_all(MYSQLI_ASSOC);

// Handle Export to Excel
if (isset($_POST['export_excel'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=data_pesanan.xls");
    echo "ID Pesanan\tTotal Harga\tTanggal Dibuat\tMenu\tJumlah\tHarga\n";
    foreach ($orders as $order) {
        echo $order['id'] . "\t" . $order['total_price'] . "\t" . $order['created_at'] . "\t" . $order['menu_name'] . "\t" . $order['quantity'] . "\t" . $order['price'] . "\n";
    }
    exit();
}

// Handle Export to PDF
if (isset($_POST['export_pdf'])) {
    header("Content-Disposition: attachment; filename=data_pesanan.pdf");
    echo "Fitur PDF akan menggunakan library seperti FPDF.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
    <link rel="stylesheet" href="../css/pesanan.css">
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

    <h1>Data Pesanan</h1>

    <!-- Form Tambah Pesanan -->
    <form method="POST" action="">
        <h3>Tambah Pesanan</h3>
        <label>Menu ID:</label>
        <input type="number" name="menu_id" required>
        <label>Jumlah:</label>
        <input type="number" name="quantity" required>
        <label>Harga:</label>
        <input type="number" name="price" required>
        <button type="submit" name="add_order">Tambah</button>
    </form>

    <!-- Tombol Ekspor -->
    <form method="POST" action="">
        <button type="submit" name="export_excel" class="button-export">Export to Excel</button>
        <button type="submit" name="export_pdf" class="button-export">Export to PDF</button>
    </form>

    <!-- Tabel Pesanan -->
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Total Harga</th>
                <th>Tanggal Dibuat</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Aksi</th>
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
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                            <input type="hidden" name="menu_id" value="<?= $order['menu_id']; ?>">
                            <input type="hidden" name="quantity" value="<?= $order['quantity']; ?>">
                            <input type="hidden" name="price" value="<?= $order['price']; ?>">
                            <button type="submit" name="edit_order">Edit</button>
                        </form>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                            <button type="submit" name="delete_order">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="../html/home.html" class="button-back">Kembali ke Home</a>
</body>
</html>
