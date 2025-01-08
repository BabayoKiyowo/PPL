<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>selamat datang </title>
    <link rel="stylesheet" href="../css/bojek.css">
</head>
<body>
    <?php
    session_start();
    if (isset($_SESSION['email'])) {
    ?>
    <div class="logo">
        <a href="#" class="logo"><img src="../images/logo.png" alt=""></a>
        <h1>Hello, <?php echo $_SESSION['name']; ?></h1>
        <!-- Tambahkan tombol logout -->
        <a href="logout.php">Logout</a>
        <a href="ProfilView.php">Profile</a>
       
    </div>
    <div class="header">
        <h1>BOJEK </h1>
        <p>bojek diskon 60%</p>
    </div>
    <div><h5>kategori</h5></div>
    <div class="categories">
        <a href="admin_dashboard.php">
            <div class="category">
                <img src="../images/bofood.png" alt="BOFOOD">
                <h2>BOFOOD</h2>
            </div>
        </a>    
       
        </a>
    </div>
    <?php
    } else {
        header("Location: admin_login.php");
        exit();
    }
    ?>
</body>
</html>
