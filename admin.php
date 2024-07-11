<?php
include 'db.php';
session_start();

// Check if the user is an admin
// This is a simple example. You should implement proper admin authentication.
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $user_id = $_POST['user_id'];
    $sql = "UPDATE users SET approved = 1 WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        echo "User approved successfully.";
        // Notify the user via email
        $sql = "SELECT email FROM users WHERE id = $user_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $to = $row['email'];
            $subject = "Account Approved";
            $message = "Your account has been approved by the admin. You can now log in.";
            mail($to, $subject, $message);
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$sql = "SELECT id, username, email FROM users WHERE approved = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Approve Users</title>
</head>
<body>
    <h2>Approve Users</h2>
    <form method="POST">
        <table border="1">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td><button type='submit' name='approve' value='1'>Approve</button><input type='hidden' name='user_id' value='" . $row['id'] . "'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No users awaiting approval</td></tr>";
            }
            ?>
        </table>
    </form>
</body>
</html>

<?php
$conn->close();
?>
