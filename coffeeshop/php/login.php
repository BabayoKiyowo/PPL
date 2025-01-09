<?php
session_start();
include "db_conn.php"; // Pastikan file koneksi database Anda sudah benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fungsi untuk membersihkan input
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Cek apakah email dan password diisi
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = validate($_POST['email']);
        $pass = validate($_POST['password']);

        // Validasi input kosong
        if (empty($email)) {
            header("Location: login.php?error=Email is required");
            exit();
        } else if (empty($pass)) {
            header("Location: login.php?error=Password is required");
            exit();
        } else {
            // Query untuk mendapatkan data admin berdasarkan email
            $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                // Verifikasi password menggunakan password_verify
                if (password_verify($pass, $row['password'])) {
                    // Set session untuk user yang berhasil login
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['id'] = $row['id'];
                    // Tutup statement
                    $stmt->close();
                    // Redirect ke home.html
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    // Password salah
                    $stmt->close();
                    header("Location: login.php?error=Incorrect email or password");
                    exit();
                }
            } else {
                // Email tidak ditemukan
                $stmt->close();
                header("Location: login.php?error=Incorrect email or password");
                exit();
            }
        }
    } else {
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Coffee Shop - Login</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css" />
</head>

<body>
    <div class="container">
        <h1>Admin Login</h1>
        <div class="image-container">
            <img src="../images/image1.png" alt="Coffee Shop" class="form-image" />
        </div>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="email" id="email" placeholder="Email" required />
            <input type="password" name="password" id="password" placeholder="Password" required />
            <button type="button" class="pil" onclick="resetPassword()">Reset Password</button>
            <button type="submit" class="pol">Login</button>
        </form>
        <a href="forgot.php">Forgot Password?</a>

        <?php
        if (isset($_GET['error']) && !empty($_GET['error'])) {
            echo '<p style="color:red;text-align:center;">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>

        <div class="copyright">&copy; 2021 Coffee Shop. All Rights Reserved</div>
    </div>
    <script>
        function resetPassword() {
            document.getElementById('password').value = '';
        }
    </script>
</body>

</html>
