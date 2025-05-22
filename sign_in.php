<?php
session_start(); 
include 'connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    $connection = CONNECTIVITY();

    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $results = $stmt->get_result();

    if ($results->num_rows > 0) {
        $user_acc = $results->fetch_assoc();

        if(password_verify($password, $user_acc['password'])) {
            $_SESSION['user_id'] = $user_acc['user_id'];
            $_SESSION['username'] = $user_acc['username'];
            $_SESSION['user_type'] = $user_acc['user_type'];

            if($_SESSION['user_type'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
        } else {
           echo "<script>alert('Incorrect password. Please try again.');</script>";
           
           
        }
    }

    $stmt->close();
    DISCONNECTIVITY($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Event Booking</title>
    <link rel="stylesheet" href="CSS/sign_in.css">
</head>
<body>
    <div class="form_container">
        <h2>Sign In to Your Account</h2>
        <form method="POST" action="">
            <div class="form_group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form_group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <input type="submit" value="Sign In" class="button_submit">
        </form>
        <div class="links">
            <a href="register.php">Don't have an account? Register here</a>
            <a href="forgot_password.php">Forgot your password? Reset it here</a>
        </div>
    </div>
</body>
</html>