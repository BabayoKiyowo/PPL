<?php
session_start();
include 'db_conn.php'; // Ensure this file contains the MySQLi connection logic

// Query untuk mengambil data dari tabel admin
$sql = "SELECT id, username, email, phone FROM admin";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Admin</title>
    <link rel="stylesheet" href="../css/user.css"> <!-- Link CSS untuk styling -->
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="user.php" class="active">Data Admin</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- Content -->
    <div class="container">
        <h1>Data Admin</h1>
        
        <!-- Tabel untuk menampilkan data -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data dari query
                if ($result->num_rows > 0) {
                    // Menampilkan setiap baris data
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["username"] . "</td>
                                <td>" . $row["email"] . "</td>
                                <td>" . $row["phone"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
