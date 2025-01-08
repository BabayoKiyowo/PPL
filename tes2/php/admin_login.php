<?php
session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST['login_id']) && isset($_POST['password'])) {
        $login_id = validate($_POST['login_id']); // Bisa email atau username
        $pass = validate($_POST['password']);

        if (empty($login_id)) {
            header("Location: admin_login.php?error=Email/Username is required");
            exit();
        } elseif (empty($pass)) {
            header("Location: admin_login.php?error=Password is required");
            exit();
        } else {
            // Query untuk mencari user berdasarkan email atau username
            $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? OR username = ?");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("ss", $login_id, $login_id); // Bind email atau username
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();

                // Verifikasi password
                if ($pass === $row['password']) { // Ganti dengan password_verify jika password sudah di-hash
                    // Set session variables
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['gender'] = $row['gender'];
                    $_SESSION['phone'] = $row['phone'];
                    $_SESSION['address'] = $row['address'];

                    // Redirect ke dashboard
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    $stmt->close();
                    header("Location: admin_login.php?error=Incorrect email/username or password");
                    exit();
                }
            } else {
                $stmt->close();
                header("Location: admin_login.php?error=User not found");
                exit();
            }
        }
    } else {
        header("Location: admin_login.php?error=Email/Username and password are required");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Coffee Shop Admin Login</title>
    <style>
        /* Styling untuk halaman login */
body {
    font-family: Arial, sans-serif;
    background-color: #f3f4f6;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background-color: #ffffff;
    width: 100%;
    max-width: 400px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    text-align: center;
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333333;
}

form {
    display: flex;
    flex-direction: column;
}

input[type="text"],
input[type="password"] {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

button {
    padding: 10px;
    background-color: #007BFF;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

a {
    display: block;
    margin-top: 10px;
    font-size: 14px;
    color: #007BFF;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>

<body>
    <div class="container">
        <h1>Admin Login</h1>
        <div class="image-container">
            <img src="../imagess/image1.png" alt="Coffee Shop" class="form-image" />
        </div>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="login_id" id="login_id" placeholder="Email or Username" required />
            <input type="password" name="password" id="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>
        <a href="forgot.php">Forgot Password?</a>

        <?php
        if (isset($_GET['error']) && !empty($_GET['error'])) {
            echo '<p style="color:red;text-align:center;">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>

        <div class="copyright">© 2025 Coffee Shop. All Rights Reserved</div>
    </div>
</body>

</html>
