<?php
session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Validate if passwords match
    if ($password != $confirmPassword) {
      $error_message = "Password and Confirm Password do not match";
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $con = mysqli_connect($serverName, $username, $pwd, $dbName);
    if (mysqli_connect_errno()) {
        echo "Gagal";
        exit();
    } else {
        $stmt = $con->prepare("INSERT INTO driver (name, email, gender, phone, address, password, kendaraan) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $email, $gender, $phone, $address, $hashed_password, $kendaraan);

        if ($stmt->execute()) {
            header("Location: admin_login.php");
        } else {
            echo "Gagal";
        }

        $stmt->close();
        $con->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration Form</title>
    <link rel="stylesheet" href="../css/styles.css" />
  </head>
  <body>
    <form class="registration-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <h2>Register</h2>
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required />

      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" required />

      <label for="gender">Gender</label>
      <select id="gender" name="gender" required>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
      </select>

      <label for="phone">Phone</label>
      <input type="tel" id="phone" name="phone" required />

      <label for="address">Address</label>
      <input type="text" id="address" name="address" required />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required />

      <label for="confirm-password">Confirm Password</label>
      <?php
        if (!empty($error_message)) {
            echo '<div class="error-message">' . $error_message . '</div>';
        }
      ?>
      <input type="password" id="confirm-password" name="confirm-password" required />

      <button type="submit">Register</button>
    </form>
  </body>
</html>
