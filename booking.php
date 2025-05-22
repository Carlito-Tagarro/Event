<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign_in.php");
    exit();
}

if (!isset($_GET['event_id'])) {
    echo "Invalid event.";
    exit();
}

$connection = CONNECTIVITY();

$event_id = intval($_GET['event_id']);
$sqlMAN = "SELECT * FROM events WHERE event_id = $event_id";
$result = $connection->query($sqlMAN);

if ($result->num_rows == 0) {
    echo "Event not found.";
    exit();
}

$event = $result->fetch_assoc();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMAILMAN/src/Exception.php';
require 'PHPMAILMAN/src/PHPMailer.php';
require 'PHPMAILMAN/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $number_of_tickets = intval($_POST['number_of_seats']);
    $payment_status = 'Pending';

    $user_sql = "SELECT email FROM users WHERE user_id = $user_id";
    $user_result = $connection->query($user_sql);
    if ($user_result->num_rows == 0) {
        echo "User not found.";
        exit();
    }
    $user = $user_result->fetch_assoc();
    $user_email = $user['email'];

    if ($number_of_tickets > $event['available_seats']) {
        echo "Not enough seats available.";
        exit();
    }

    $connection->begin_transaction();

    try {
        date_default_timezone_set('Asia/Manila');
        $booking_date = date('Y-m-d H:i:s'); 

        $total_price = $event['event_ticket_price'] * $number_of_tickets;
        $insert_ticket = "INSERT INTO tickets (user_id, event_id, number_of_tickets, total_price, booking_date, payment_status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_ticket);
        $stmt->bind_param("iiidss", $user_id, $event_id, $number_of_tickets, $total_price, $booking_date, $payment_status);
        $stmt->execute();

        $conn->commit();

        $mail = new PHPMailer(true);
        try {
            
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'carlitotagarro27@gmail.com'; 
            $mail->Password = 'lszvvhaevdddeaps'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->Port = 465;

            
            $mail->setFrom('carlitotagarro27@gmail.com', 'Event Booking'); 
            $mail->addAddress($user_email); 
            $mail->isHTML(true);
            $mail->Subject = 'Booking Confirmation';
            $mail->Body = "
                <h1>Booking Confirmation</h1>
                <p>Thank you for booking tickets for <strong>{$event['event_name']}</strong>.</p>
                <p><strong>Number of Tickets:</strong> {$number_of_tickets}</p>
                <p><strong>Date:</strong> {$event['event_date']}</p>
                <p><strong>Venue:</strong> {$event['venue']}</p>
                <p><strong>Total Price:</strong> ₱" . number_format($total_price, 2) . "</p>
                <p><a href='http://yourwebsite.com/confirm_payment.php?ticket_id={$stmt->insert_id}' style='display: inline-block; padding: 10px 20px; color: #fff; background-color: #28a745; text-decoration: none; border-radius: 5px;'>Confirm Payment</a></p>
            ";

            $mail->send();
        } catch (Exception $e) {
            
            error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
            echo "Email could not be sent. Please try again later.";
        }
        header("Location: confirmation.php?ticket_id={$stmt->insert_id}&alert=sent");
        exit();
    } catch (Exception $e) { 
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}

$stmt->close();
DISCONNECTIVITY($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link rel="stylesheet" href="CSS/booking.css">

</head>
<body>
    <header>
        <a href="index.php">Home</a>
        <a href="events.php">Events</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </header>
    <div class="container">
        <h1>Confirm Booking</h1>
        <p><strong>Event:</strong> <?php echo htmlspecialchars($event['event_name']); ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?></p>
        <p><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue']); ?></p>
        <p><strong>Ticket Price:</strong> ₱<?php echo htmlspecialchars(number_format($event['event_ticket_price'], 2)); ?></p>
        <form method="POST">
            <label for="number_of_seats">Number of Tickets:</label>
            <input type="number" id="number_of_seats" name="number_of_seats" min="1" value="1" required>
            <label for="payment_status">Payment Status:</label>
            <button type="submit" id="confirm_button">Confirm Booking</button>
        </form>
    </div>
</body>
</html>