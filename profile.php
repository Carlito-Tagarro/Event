<?php
 include 'connection.php'; 

 session_start();
 $user_id = $_SESSION['user_id']; 


    $connection =CONNECTIVITY(); 


    $sqlMan = "SELECT ticket_id, user_id, event_id, booking_date, number_of_tickets, total_price , payment_status FROM tickets WHERE user_id = ?";
    $stmt = $connection->prepare($sqlMan);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();


    $user_sql = "SELECT username, email FROM users WHERE user_id = ?";
    $user_stmt = $connection->prepare($user_sql);
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    $user = $user_result->fetch_assoc();



    $user_result->close();
    $stmt->close();
    DISCONNECTIVITY($connection);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/profile.css"> 
    <title>User Profile</title>
</head>

<nav>
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="sign_in.php">Sign In</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
<body>
    <br>
    
    <div class="profile_header">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    </div>

    <h1 style="text-align:center; ;">Your Booked Tickets</h1>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Event ID</th>
                    <th>Booking Date</th>
                  
                </tr>
            </thead>
            <tbody>
                <?php while ($rows = $result->fetch_assoc()): ?>
                   <?php if($rows['payment_status'] == 'Pending') { ?>
                                                 
                        <?php } else{?>
                        <tr> 
                            <td><?php echo htmlspecialchars($rows['ticket_id']); ?></td>
                            <td><?php echo htmlspecialchars($rows['event_id']); ?></td>
                            <td><?php echo htmlspecialchars($rows['booking_date']); ?></td>
                          
                        </tr>
                        <?php } ?>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p >You have not booked any tickets yet</p>
    <?php endif; ?>
</body>
</html>