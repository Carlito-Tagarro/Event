<?php
session_start(); 
include 'connection.php'; 


$connection = CONNECTIVITY();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <h1>HELLO</h1>
</body>

<?php
DISCONNECTIVITY($connection);
?>
</html>