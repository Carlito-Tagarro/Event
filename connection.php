<?php
function CONNECTIVITY() {
    $servername = "localhost"; 
    $username = "root"; 
    $password = "CARLITO27"; 
    $dbname = "event_ticket_booking"; 

    
    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failure " . $connection->connect_error);
    }
    return $connection;
}

function DISCONNECTIVITY($connection) {
    $connection->close();
}

?>