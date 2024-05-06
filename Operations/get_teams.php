<?php
//establish a connection and start session
include("connection.php");
session_start();

// Fetch teams from the database
$sql = "SELECT * FROM teamregistration";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Store results in an array
    $teams = array();
    while ($row = $result->fetch_assoc()) {
        $teams[] = $row;
    }
    // Output JSON
    echo json_encode($teams);
} else {
    echo "No teams found";
}

// Close connection
$conn->close();
