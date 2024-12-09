<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php'); // Jika belum login, arahkan ke halaman login
    exit();
}

include('db_connect.php');

// Query untuk mengambil data pesanan
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Dashboard Admin - Laporan Pesanan</h1>
    <a href="admin_logout.php">Logout</a>

    <h2>Daftar Pesanan</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['description'] . "</td>
                            <td>" . $row['price'] . "</td>
                            <td>" . $row['quantity'] . "</td>
                            <td>" . $row['total'] . "</td>
                            <td>" . $row['order_date'] . "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada pesanan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
