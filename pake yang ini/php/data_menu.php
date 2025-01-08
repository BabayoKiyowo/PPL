<?php
session_start();
include 'db_conn.php'; // Pastikan file ini berisi koneksi ke database

// Fetch menu data
$queryMenu = "SELECT * FROM menu";
$resultMenu = $conn->query($queryMenu);
$menu = $resultMenu->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Menu</title>
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
    <h1>Data Menu</h1>
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
    <a href="../html/home.html">Kembali ke Home</a>
</body>
</html>
