<?php
 include 'connection.php'; 

 session_start();
 $user_id = $_SESSION['user_id']; 

 $connection =CONNECTIVITY(); 

 
 $sqlMan = "SELECT t.ticket_id, t.user_id, t.event_id, t.booking_date, t.number_of_tickets, t.total_price, t.payment_status, e.image_url, e.event_name, e.event_date
            FROM tickets t
            JOIN events e ON t.event_id = e.event_id
            WHERE t.user_id = ?";
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
   
</head>
<body>
  
    <nav>
        <a href="index.php"><strong>HOME</strong></a>
        <a href="event.php"><strong>EVENTS</strong></a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php"><strong>PROFILE</strong></a>
            <a href="logout.php"><strong>LOGOUT</strong></a>
        <?php else: ?>
            <a href="sign_in.php"><strong>SIGN IN</strong></a>
            <a href="register.php"><strong>REGISTER</strong></a>
        <?php endif; ?>
    </nav>
    <main>
        <div class="profile-container">
            <div class="profile_header">
                <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
       
            <div class="tickets-title">YOUR BOOKED TICKETS</div>
            <?php if ($result->num_rows > 0): ?>
                <div class="etickets-grid">
                    <?php while ($rows = $result->fetch_assoc()): ?>
                        <?php if($rows['payment_status'] != 'Pending' && $rows['payment_status'] != 'Cancel'): ?>
                            <div class="eticket-card">
                                <div class="eticket-header">
                                    <div class="event-title"><?php echo htmlspecialchars($rows['event_name']); ?></div>
                                    <div class="event-artist">Event ID: <?php echo htmlspecialchars($rows['event_id']); ?></div>
                                </div>
                                <div class="eticket-body">
                                    <div class="eticket-info-row">
                                        <div class="eticket-info-col">
                                            <div class="eticket-info-label">Ticket ID</div>
                                            <div class="eticket-info-value"><?php echo htmlspecialchars($rows['ticket_id']); ?></div>
                                        </div>
                                        <div class="eticket-info-col">
                                            <div class="eticket-info-label">User ID</div>
                                            <div class="eticket-info-value"><?php echo htmlspecialchars($rows['user_id']); ?></div>
                                        </div>
                                    </div>
                                    <div class="eticket-info-row">
                                        <div class="eticket-info-col">
                                            <div class="eticket-info-label">Event Date</div>
                                            <div class="eticket-info-value"><?php echo htmlspecialchars($rows['event_date']); ?></div>
                                        </div>
                                    </div>
                                    <div class="eticket-barcode">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x40&data=<?php echo urlencode($rows['ticket_id']); ?>" alt="Barcode">
                                        <div class="eticket-barcode-code"><?php echo htmlspecialchars($rows['ticket_id']); ?></div>
                                    </div>
                                    <!-- <button class="save-ticket-btn">SAVE TICKET</button> -->
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="no-tickets-msg">You have not booked any tickets yet</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>