<?php
include "db_conn.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $oldPassword = $_POST['old-password'];
    $newPassword = $_POST['new-password'];

    // Validasi form jika diperlukan

    $selectSql = "SELECT id, password FROM admin_users WHERE username = ?";
    $stmtSelect = $conn->prepare($selectSql);
    $stmtSelect->bind_param("s", $username);
    $stmtSelect->execute();
    $resultSelect = $stmtSelect->get_result();

    if ($resultSelect->num_rows == 1) {
        $row = $resultSelect->fetch_assoc();
        $userId = $row['id'];
        $hashedPassword = $row['password'];

        // Verifikasi kata sandi lama
        if (password_verify($oldPassword, $hashedPassword)) {
            // Kata sandi lama cocok, update kata sandi baru
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateSql = "UPDATE admin_users SET password = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("si", $newHashedPassword, $userId);
            $updateStmt->execute();

            header("Location: index.php");
            exit();
        } else {
            header("Location: forgot.php?error=Kata%20sandi%20lama%20tidak%20cocok");
            exit();
        }
    } else {
        header("Location: forgot.php?error=Pengguna%20tidak%20ditemukan");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h2>Ganti Password</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="old-password">Kata Sandi Lama:</label>
            <input type="password" id="old-password" name="old-password" required>
        </div>
        <div>
            <label for="new-password">Kata Sandi Baru:</label>
            <input type="password" id="new-password" name="new-password" required>
        </div>
        <button type="submit">Ganti Password</button>

        <?php
        if (isset($_GET['error']) && !empty($_GET['error'])) {
            echo '<p style="color:red;text-align:center;">' . $_GET['error'] . '</p>';
        }
        ?>
    </form>
</body>

</html>
