<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_user = $_POST['username'];
    $admin_password = $_POST['password'];

    $sql = "SELECT id, username, password_hash, is_admin FROM users WHERE username='$admin_user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_hashed_password = $row['password_hash'];

        if ($row['is_admin'] == 1 && password_verify($admin_password, $stored_hashed_password)) {
            $_SESSION['admin'] = true;
            $_SESSION['admin_id'] = $row['id'];
            header("Location: admin.php");
            exit();
        } else {
            echo "Invalid credentials or not an admin.";
        }
    } else {
        echo "No admin user found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form method="POST">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
