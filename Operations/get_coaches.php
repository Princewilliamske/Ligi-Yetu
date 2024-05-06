<?php
// Establish a connection to the database
include("connection.php");
session_start();

// Fetch coach data from the database
$sql = "SELECT * FROM coachregistration";
$result = $conn->query($sql);

// Check if any coach data was fetched
if ($result->num_rows > 0) {
    // Fetch each row of coach data
    $coaches = array();
    while ($row = $result->fetch_assoc()) {
        $coach[] = $row;
    }
    // Send coach data as JSON response
    echo json_encode($coach);
} else {
    echo "No coaches found";
}

// Close database connection
$conn->close();
