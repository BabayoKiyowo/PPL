<?php
session_start();
include "db_conn.php";

// Fungsi untuk validasi input
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cek jika username dan password ada
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = validate($_POST['username']);
        $pass = validate($_POST['password']);

        // Cek jika username atau password kosong
        if (empty($username)) {
            header("Location: admin_login.php?error=Username is required");
            exit();
        } else if (empty($pass)) {
            header("Location: admin_login.php?error=Password is required");
            exit();
        } else {
            // Query untuk mencari username di database
            $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            // Jika username ditemukan
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();

                // Debugging: Tampilkan username dan password
                // echo "Username yang dimasukkan: " . $username;
                // echo "<br>Username yang diambil dari DB: " . $row['username'];
                // echo "<br>Password yang dimasukkan: " . $pass;
                // echo "<br>Password yang disimpan di DB: " . $row['password'];

                // Verifikasi password menggunakan password_verify
                if (password_verify($pass, $row['password'])) {
                    // Jika password cocok, set session
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['id'] = $row['id'];

                    // Redirect ke admin_dashboard.php
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    // Password tidak cocok
                    $stmt->close();
                    header("Location: admin_login.php?error=Incorrect username or password");
                    exit();
                }
            } else {
                // Username tidak ditemukan
                $stmt->close();
                header("Location: admin_login.php?error=Incorrect username or password");
                exit();
            }
        }
    } else {
        header("Location: admin_login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login</title>
    <style>body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 300px;
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    background-color: #5c6bc0;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #3f4c9a;
}

a {
    text-decoration: none;
    color: #5c6bc0;
    display: block;
    margin-top: 10px;
}

a:hover {
    color: #3f4c9a;
}

.copyright {
    font-size: 12px;
    color: #888;
    margin-top: 20px;
}
</style>
</head>

<body>
    <div class="container">
        <h1>Admin Login</h1>
        <div class="image-container">
            <img src="../imagess/image 1.png" alt="Image" class="form-image" />
        </div>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" id="username" placeholder="Username" />
            <input type="password" name="password" id="password" placeholder="Password" />
            <button type="button" class="pil" onclick="resetPassword()">Reset Password</button>
            <button type="submit" class="pol">Login</button>
        </form>

        <a href="forgot.php">Forgot Password?</a>

        <?php
        if (isset($_GET['error']) && !empty($_GET['error'])) {
            echo '<p style="color:red;text-align:center;">' . $_GET['error'] . '</p>';
        }
        ?>

        <div class="copyright">© 2021 Coffee Shop. All Rights Reserved</div>
    </div>

    <script>
        function resetPassword() {
            document.getElementById('password').value = '';
        }
    </script>
</body>

</html>
