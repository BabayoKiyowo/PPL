<?php
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
    <title>Menu Cafe</title>
</head>
<body>
    <h1>Daftar Pesanan</h1>
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
