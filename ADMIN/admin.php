<?php
session_start(); 
include 'connection.php'; 

$conn = CONNECTIVITY();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $venue = $_POST['venue'];
    $available_seats = $_POST['available_seats'];
    $description = $_POST['description'];
    $event_ticket_price = $_POST['event_ticket_price'];
    $category = $_POST['category'];

  
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        $target_direction = "images/";
        $targetfile = $target_direction . basename($_FILES['image_file']['name']);
        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetfile)) {
            $image_url = $targetfile;
        } else {
            echo "Error uploading the image.";
            exit;
        }
    } else {
        echo "No image uploaded or an error occurred.";
        exit;
    }

    $sql = "INSERT INTO events (event_name, event_date, venue, available_seats, description, event_ticket_price, category, image_url, created_at) 
            VALUES ('$event_name', '$event_date', '$venue', $available_seats, '$description', $event_ticket_price, '$category', '$image_url', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
        echo "Event added successfully!";
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

DISCONNECTIVITY($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/">
    <title>Admin God</title>
</head>
<body>
    <h2>Add Event</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="event_name">Event Name:</label>
        <input type="text" id="event_name" name="event_name" required><br>

        <label for="event_date">Event Date and Time:</label>
        <input type="datetime-local" id="event_date" name="event_date" required><br>

        <label for="venue">Venue:</label>
        <input type="text" id="venue" name="venue" required><br>

        <label for="available_seats">Available Seats:</label>
        <input type="number" id="available_seats" name="available_seats" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="event_ticket_price">Ticket Price:</label>
        <input type="number" id="event_ticket_price" name="event_ticket_price" required><br>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required><br>

        <label for="image_file">Upload Image:</label>
        <input type="file" id="image_file" name="image_file" accept="image/*" required><br>

        <button type="submit">Add Event</button>
    </form>
</body>
</html>