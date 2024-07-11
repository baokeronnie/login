<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_user = $_POST['username'];
    $input_password = $_POST['password'];

    $sql = "SELECT id, username, password_hash, approved FROM users WHERE username='$input_user' OR email='$input_user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_hashed_password = $row['password_hash'];

        if ($row['approved'] == 0) {
            echo "Your account is awaiting approval from an admin.";
        } elseif (password_verify($input_password, $stored_hashed_password)) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: members.php");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        Username or Email: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</body>
</html>
