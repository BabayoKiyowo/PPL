<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include '../database/db_config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil menu yang ingin diubah
    $menu_sql = "SELECT * FROM menu WHERE id = ?";
    $stmt = $conn->prepare($menu_sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $menu = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];
    $customization = $_POST['customization'];

    $update_sql = "UPDATE menu SET name_ = ?, price = ?, category = ?, image_url = ?, customization = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('sisssi', $name, $price, $category, $image_url, $customization, $id);
    $stmt->execute();

    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Menu</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <h2>Update Menu</h2>
    <form method="POST" action="">
        <label>Nama Menu:</label><br>
        <input type="text" name="name" value="<?php echo $menu['name_']; ?>" required><br>
        <label>Harga:</label><br>
        <input type="number" name="price" value="<?php echo $menu['price']; ?>" required><br>
        <label>Kategori:</label><br>
        <input type="text" name="category" value="<?php echo $menu['category']; ?>" required><br>
        <label>URL Gambar:</label><br>
        <input type="text" name="image_url" value="<?php echo $menu['image_url']; ?>"><br>
        <label>Kustomisasi:</label><br>
        <textarea name="customization"><?php echo $menu['customization']; ?></textarea><br>
        <button type="submit">Update Menu</button>
    </form>
</body>
</html>
