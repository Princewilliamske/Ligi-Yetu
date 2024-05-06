<?php
// Establish a connection to the database and start session
include("connection.php");
session_start();

// Query to retrieve player data
$sql = "SELECT * FROM players";

// Execute the query
$result = mysqli_query($con, $sql);

// Check if any rows are returned
if (mysqli_num_rows($result) > 0) {
    // Array to store player data
    $players = array();

    // Fetch each row and add it to the players array
    while ($row = mysqli_fetch_assoc($result)) {
        $players[] = $row;
    }

    // Close the database connection
    mysqli_close($con);

    // Send the player data as JSON response
    header('Content-Type: application/json');
    echo json_encode($players);
} else {
    // No players found
    echo json_encode(array('message' => 'No players found'));
}
