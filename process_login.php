<?php
session_start();

$database_name = 'barangay_db';

$conn = mysqli_connect("localhost", "your_mysql_username", "your_mysql_password", $database_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Use isset to check if the keys are set in the $_POST array
$username = isset($_POST['username']) ? trim($_POST['username']) : '';

// Debugging statement
echo "Username: $username <br>";

$sql = "SELECT id, username, role FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if ($result !== false) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == 'admin') {
            header("Location: admin_homepage.php");
            exit;
        } else {
            header("Location: barangay_homepage.php");
            exit;
        }
    } else {
        echo "User not found. <a href='login.php'>Try again</a>";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
