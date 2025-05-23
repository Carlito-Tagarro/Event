<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign_in.php");
    exit();
}


if (isset($_GET['alert'])) {
    if ($_GET['alert'] == 'sent') {
        echo "<script>alert('Confirmation has been sent to your email!');</script>";
       
    } elseif ($_GET['alert'] == 'fail') {
        echo "<script>alert('Failed to send on your email.');</script>";
    }
}


$connection = CONNECTIVITY();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link rel="stylesheet" href="CSS/receipt.css">
   
    <style>

    </style>
</head>
<body>

    
    

    <header>
    <div class = "home_container">
       <a href="index.php" class="home_button">Home</a>
    </div>
    </header>

   <?php

    DISCONNECTIVITY($connection);
    ?>
</body>
</html>