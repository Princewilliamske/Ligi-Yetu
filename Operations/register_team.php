<?php
include("connection.php");
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $teamName = $_POST['teamName'];
    $Sport = $_POST['sport'];
    $coachName = $_POST['coachName'];
    $tmno = $_POST['tmnumber'];
    $numberOfPlayers = $_POST['numberOfPlayers'];

    // Handle file upload
    $target_dir = "uploads/team"; // Directory where uploaded files will be stored
    $target_file = $target_dir . basename($_FILES["teamPhoto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["teamPhoto"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["teamPhoto"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Try to upload the file
        if (move_uploaded_file($_FILES["teamPhoto"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["teamPhoto"]["name"])) . " has been uploaded.";
            // Insert the data into the database
            $filePath = $target_file;
            $sql = "INSERT INTO teams (team_name, sport, coach_name, tm_number, team_photo) VALUES ('$teamName', '$Sport', '$coachName', '$tmno' '$numberOfPlayers', '$filePath')";
            if ($conn->query($sql) === TRUE) {
                // Redirect back to the form page with a success message
                header("Location: {$_SERVER['HTTP_REFERER']}?success=1");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close the database connection
$conn->close();

