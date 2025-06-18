<?php
session_start(); 
include 'connection.php'; 


if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php"); 
    exit;
}

$conn = CONNECTIVITY();


DISCONNECTIVITY($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/admin.css">
    <title>Eventure Admin</title>
    
</head>
<body>
    <header>
        <h1><a href="admin.php">Admin Dashboard</a></h1>
        <nav>
            <ul>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Admin Controls</h2>
        <p class="subtitle">Welcome, manage your events and users below.</p>
        <div class="admin-card">
            <div class="admin-btn-group">
                <a href="addEvent.php" class="admin-btn">Manage Events</a>
                <a href="manageBooking.php" class="admin-btn">Manage Bookings</a>
                <a href="manageUser.php" class="admin-btn">Manage Users</a>
            </div>
        </div>
    </div>
</body>
</html>