<?php
session_start(); 
include 'connection.php'; 


$connection = CONNECTIVITY();


$sqlMAN = "SELECT event_id, event_name, event_date, venue, available_seats, 
               description, created_at, event_ticket_price, seats_booked, category, image_url
        FROM events
        WHERE available_seats > 0
        ORDER BY RAND()
        LIMIT 3"; 
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


</style>


<body>

    <header>
        <h1>EVENTURE</h1>
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
    <div style="display: flex; align-items: center; justify-content: center; min-height: 500px; gap: 3rem; background: #fafafa;  margin: 2rem 0;">
        <div style="flex: 1; max-width: 500px; padding: 2rem; margin: 0 2rem">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                <div style="width: 32px; height: 3px; background: #888; border-radius: 2px;"></div>
                <span style="color: #d90429; font-weight: 600; letter-spacing: 1px; font-size: 0.95rem;">EVENTURE</span>
            </div>
            <h2 style="font-size: 2rem; font-weight: 800; color: #222; margin: 0 0 1rem 0; line-height: 1.2;">
                Watch Shows and Concerts<br>with Friends &amp; Family
            </h2>
            <p style="color: #444; font-size: 1.05rem; margin-bottom: 2rem;">
                Unlocked your unforgettable experience here at Eventure and book your tickets now.
            </p>
        </div>
        <div style="flex: 1; display: flex; justify-content: center;">
            <img src="images/eventImage.jpg" alt="" style="width: 100%; max-width: 600px; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">
        </div>
    </div>
     <div class="formoviebackground">
        <h4 style="text-align: center; color: #fff;" >FEATURED EVENTS</h4>

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
        <?php endif; ?>

        <button class="view_more_events"><a href="event.php">View more Events</a></button>
        </div>
</main>
    <br>
    <br>
    <br>
    <div class="footer">
        <footer>
        <p>&copy; <?php echo date("Y"); ?> EVENTURE The No.1 Booking Place. All rights reserved.</p>
        </footer>
    </div>


    <?php

    DISCONNECTIVITY($connection);
    ?>
</body>
</html>