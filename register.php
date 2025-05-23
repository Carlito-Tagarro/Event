<?php
include 'connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $user_type = 'booker'; 

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    if (empty($username) || empty($password) || empty($email)) {
        echo "All fields are required.";
        exit;
    }

    $connection = CONNECTIVITY();

    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username or email already exists.";
    } else {
        $stmt = $connection->prepare("INSERT INTO users (username,password, email, user_type) VALUES (?, ?, ?,?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $user_type);

        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: sign_in.php");
        } else {
            echo "Error: " . $stmt->error;
            header("Location: register.php");
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
    <title>Register</title>
    <link rel="stylesheet" href="CSS/register.css"> 
</head>
<body>
    <div class="form_container">
        <h2>Register</h2>
        <form method="POST" action="">
            <div class="form_group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form_group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form_group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <input type="submit" value="Register" class="button_submit">
        </form>
        <div class="links">
            <a href="sign_in.php">Already have an account? Sign in</a>
        </div>
    </div>
</body>
</html>