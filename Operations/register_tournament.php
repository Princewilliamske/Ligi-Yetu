<?php
// Establish a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "league"; // Replace "your_database_name" with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $tournamentName = $_POST['tournamentName'];
    $game = $_POST['game'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // SQL statement to insert data into the database
    $sql = "INSERT INTO tournaments (tournamentName, game, startDate, endDate) VALUES ('$tournamentName', '$game', '$startDate', '$endDate')";

    if ($conn->query($sql) === TRUE) {
        // Return success response
        echo json_encode(["success" => true]);
    } else {
        // Return error response
        echo json_encode(["success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
}

// Close the database connection
$conn->close();
?>
