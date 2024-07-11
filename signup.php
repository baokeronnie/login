<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $plain_password = $_POST['password'];
    $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password_hash, approved) VALUES ('$user', '$email', '$hashed_password', 0)";

    if ($conn->query($sql) === TRUE) {
        echo "Sign up successful. Please wait for admin approval. <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form method="POST">
        Username: <input type="text" name="username" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
