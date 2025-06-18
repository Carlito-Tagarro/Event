<?php 

session_start();

include 'connection.php';

$conn = CONNECTIVITY();

// Handles user deletion 
if (isset($_GET['delete_user_id'])) {
    $delete_id = intval($_GET['delete_user_id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manageUser.php");
    exit();
}

$users = [];
$result = $conn->query("SELECT user_id, username, email, user_type, created_at FROM users WHERE user_type = 'booker'");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}


DISCONNECTIVITY($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User</title>
    <link rel="stylesheet" href="CSS/manageUser.css">
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
        <!-- User accounts table --> 
         
        <h2>USER ACCOUNTS</h2>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['user_type']); ?></td>
                            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            <td>
                                <a href="manageUser.php?delete_user_id=<?php echo $user['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" style="color:red;">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
