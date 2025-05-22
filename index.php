<?php
session_start(); 
include 'connection.php'; 


$connection = CONNECTIVITY();


$update_seats = "UPDATE events e JOIN tickets t ON e.event_id =  t.event_id SET e.seats_booked = e.seats_booked WHERE t.payment_status = 'confirmed'";
$connection->query($update_seats);


$sqlMAN = "SELECT event_id, event_name, event_date, venue, available_seats, 
               description, created_at, event_ticket_price, seats_booked, category, image_url
        FROM events
        WHERE available_seats > 0"; 
$result = $connection->query($sqlMAN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Event Ticket Booking</title>
    <link rel="stylesheet" href="CSS/index.css"> 
  
</head>
<body>

    <header>
        <h1>Eventure</h1>
    </header>
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
      
        
        <div class="bannerindex1"><img src="images/bannerindex.png" alt=""></div>
        <br>
        <br>
        <br>
        <div class="formoviebackground">
        <h4 style="text-align: center; color: #fff;" >UPCOMING EVENTS</h4>

        <?php if ($result->num_rows > 0): ?>
            <div class="event_container">
                <?php while ($rows = $result->fetch_assoc()): ?>
                    <div class="event_card">
                         <img src="<?php echo htmlspecialchars($rows['image_url']); ?>" alt="EventImage" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                        <h4><?php echo htmlspecialchars($rows['event_name']); ?></h4>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars(date("Y-m-d h:i A", strtotime($rows['event_date']))); ?></p>
                        <p><strong>Venue:</strong> <?php echo htmlspecialchars($rows['venue']); ?></p>
                        <p><strong>Available Seats:</strong> <?php echo htmlspecialchars($rows['available_seats']); ?></p>
                        <p><strong>Booked Seats:</strong> <?php echo htmlspecialchars($rows['seats_booked'] ?? '0'); ?></p>
                        <p><strong>Ticket Price:</strong> ₱<?php echo htmlspecialchars(number_format($rows['event_ticket_price'], 2)); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($rows['description']); ?></p>

                        <?php if ($rows['seats_booked'] == $rows['available_seats']): ?>
                            <button disabled>Fully Booked</button>
                        <?php else: ?>
                            <a href="booking.php?event_id=<?php echo $rows['event_id']; ?>">Book Now</a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div> 
        <?php else: ?>
            <p style="text-align: center;">No events available at the moment.</p>
        <?php endif; ?>
        </div>
    </main>
    <br>
    <br>
    <br>
    <div class="footer">
        <footer>
        <p>&copy; <?php echo date("Y"); ?> Eventure The No.1 Booking Place. All rights reserved.</p>
        </footer></div>

    <?php

    DISCONNECTIVITY($connection);
    ?>
</body>
</html>