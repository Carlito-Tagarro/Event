<?php 
session_start();
include 'connection.php';

$conn = CONNECTIVITY();


$conn->query("
    DELETE t FROM tickets t
    INNER JOIN events e ON t.event_id = e.event_id
    WHERE e.event_date < CURDATE()
");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticket_id'], $_POST['new_status'])) {
    $ticket_id = intval($_POST['ticket_id']);
    $new_status = ($_POST['new_status'] === 'Confirm') ? 'Confirm' : 'Cancel';
    $stmt = $conn->prepare("UPDATE tickets SET payment_status = ? WHERE ticket_id = ?");
    $stmt->bind_param("si", $new_status, $ticket_id);
    $stmt->execute();
    $stmt->close();
}


$tickets = [];
$result = $conn->query("SELECT * FROM tickets");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }
}

DISCONNECTIVITY($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="CSS/manageBooking.css">
    <link rel="stylesheet" href="CSS/admin.css">
</head>
<body>
       <header class="header">
        <h1><a href="admin.php" style="color:crimson;text-decoration:none;">Admin Dashboard</a></h1>
            
        <nav>
            <ul>
                <li><a href="addEvent.php">Add Event</a></li>
                <li><a href="manageBooking.php">Manage Bookings</a></li>
                <li><a href="manageUser.php">View Users</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
    </header>
    <main style="padding: 2rem;">
        <h2>Manage Bookings</h2>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>User ID</th>
                    <th>Event ID</th>
                    <th>Booking Date</th>
                    <th>Number of Tickets</th>
                    <th>Total Price</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tickets)): ?>
                    <tr><td colspan="8" style="text-align:center;">No bookings found.</td></tr>
                <?php else: ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <tr>
                            <td><?= htmlspecialchars($ticket['ticket_id']) ?></td>
                            <td><?= htmlspecialchars($ticket['user_id']) ?></td>
                            <td><?= htmlspecialchars($ticket['event_id']) ?></td>
                            <td><?= htmlspecialchars($ticket['booking_date']) ?></td>
                            <td><?= htmlspecialchars($ticket['number_of_tickets']) ?></td>
                            <td><?= htmlspecialchars($ticket['total_price']) ?></td>
                            <td><?= htmlspecialchars($ticket['payment_status']) ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="ticket_id" value="<?= $ticket['ticket_id'] ?>">
                                    <button type="submit" name="new_status" value="Confirm" <?= $ticket['payment_status'] === 'Confirm' ? 'disabled' : '' ?>>Confirm</button>
                                    <button type="submit" name="new_status" value="Cancel" <?= $ticket['payment_status'] === 'Cancel' ? 'disabled' : '' ?>>Cancel</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>