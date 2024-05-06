<?php
// Establish a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "league"; // Replace 'your_database_name' with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch tournaments from the database
$sql = "SELECT * FROM tournaments";

$result = $conn->query($sql);

$tournaments = array();

if ($result->num_rows > 0) {
    // Fetch each row of the result as an associative array
    while($row = $result->fetch_assoc()) {
        $tournaments[] = $row;
    }
}

// Close the connection
$conn->close();

// Send the tournaments data as JSON
header('Content-Type: application/json');
echo json_encode($tournaments);
?>
