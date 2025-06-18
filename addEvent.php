<?php
session_start(); 
include 'connection.php'; 


if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php"); 
    exit;
}

$conn = CONNECTIVITY();

// Automatically delete past events 
$conn->query("DELETE FROM events WHERE event_date < (NOW() - INTERVAL 1 DAY)");


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_event_id'])) {
    $delete_id = intval($_POST['delete_event_id']);
    $conn->query("DELETE FROM events WHERE event_id = $delete_id");
    header("Location: addEvent.php");
    exit;
}

// Handle event addition if form is submitted and not a delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['delete_event_id'])) {
   
    
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $venue = $_POST['venue'];
    $available_seats = $_POST['available_seats'];
    $description = $_POST['description'];
    $event_ticket_price = $_POST['event_ticket_price'];
    $category = $_POST['category'];

    // Handles the image upload
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        $target_direction = "images/";
        $targetfile = $target_direction . basename($_FILES['image_file']['name']);
        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetfile)) {
            $image_url = $targetfile;
        } 
        else {
            echo "Error uploading the image.";
            exit;
        }
    } 
    else {
        echo "No image uploaded or an error occurred.";
        exit;
    }

    
    $sql = "INSERT INTO events (event_name, event_date, venue, available_seats, description, event_ticket_price, category, image_url, created_at) 
            VALUES ('$event_name', '$event_date', '$venue', $available_seats, '$description', $event_ticket_price, '$category', '$image_url', NOW())";

    if ($conn->query($sql) == TRUE) {
        header("Location: addEvent.php");
        echo "<script>alert('Event added successfully!');</script>";

    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$events_result = $conn->query("SELECT * FROM events ORDER BY event_date DESC");

DISCONNECTIVITY($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/addEvent.css">
    <link rel="stylesheet" href="CSS/admin.css">
    <title>Add Event</title>
   
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
    <!-- Event addition form -->
    <div class="main-flex-container">
       
        <div class="form-container">
            <h2 style="margin-bottom:0;">Add Event</h2>
            <br><br>
            <form method="POST" action="" enctype="multipart/form-data">
                <label for="event_name">Event Name</label>
                <input type="text" id="event_name" name="event_name"  required>

                <label for="event_date">Event Date & Time</label>
                <input type="datetime-local" id="event_date" name="event_date" required>

                <label for="venue">Venue</label>
                <input type="text" id="venue" name="venue"  required>

                <label for="available_seats">Available Seats</label>
                <input type="number" id="available_seats" name="available_seats" min="1"  required>

                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Brief event details..." required></textarea>

                <label for="event_ticket_price">Ticket Price (in ₱)</label>
                <input type="number" id="event_ticket_price" name="event_ticket_price" min="0" step="0.01"  required>

                <label for="category">Category</label>
                <input type="text" id="category" name="category" placeholder="e.g. concert, movie, festival" required>

                <label for="image_file">Upload Image</label>
                <input type="file" id="image_file" name="image_file" accept="image/*" required>

                <button type="submit">Add Event</button>
            </form>
        </div>

        <!-- List of existing events with delete option -->
        <div class="events-container">
            <h2>Listed Events</h2>
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="border-bottom:1px solid #ccc;">Event Name</th>
                        <th style="border-bottom:1px solid #ccc;">Date & Time</th>
                        <th style="border-bottom:1px solid #ccc;">Venue</th>
                        <th style="border-bottom:1px solid #ccc;">Category</th>
                        <th style="border-bottom:1px solid #ccc;">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($events_result && $events_result->num_rows > 0): ?>
                    <?php while($row = $events_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['venue']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td>
                            <!-- Delete event button -->
                            <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this event?');" style="display:inline;">
                                <input type="hidden" name="delete_event_id" value="<?php echo $row['event_id']; ?>">
                                <button type="submit" style="background:#e74c3c;color:#fff;border:none;padding:5px 10px;border-radius:3px;cursor:pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center;">No events found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>