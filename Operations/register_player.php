<?php
// Establish a connection to the database
include("connection.php");
include("functions.php");
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $surName = $_POST['surName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $sport = $_POST['sport'];
    $team = $_POST['team'];
    $position = $_POST['position'];
    $contactNo = $_POST['contactNo'];
    
    // Validate file
    $targetDir = "uploads/players"; // Directory where images will be stored
    $targetFile = $targetDir . basename($_FILES["image"]["name"]); // Path to store the uploaded image
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION)); // Get the file extension

    // Check if file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        echo "File is not an image.";
        exit();
    }

    // Check file size (limit to 5MB)
    if ($_FILES["image"]["size"] > 5 * 1024 * 1024) {
        echo "Sorry, your file is too large. Max file size is 5MB.";
        exit();
    }

    // Allow certain file formats (only JPG, JPEG, PNG, and GIF files are allowed)
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        exit();
    }

    // Generate a unique file name to prevent overwriting existing files
    $uniqueFileName = uniqid() . '.' . $imageFileType;
    $filePath = $targetDir . $uniqueFileName;

    // Upload the image
    if(move_uploaded_file($_FILES["image"]["tmp_name"], $filePath)) {
        // Image uploaded successfully, store the file path in the database

        // Prepare the SQL statement with parameter binding
        $stmt = mysqli_prepare($con, "INSERT INTO palayerregistration (surname, middlename, lastname, sport, team, fieldposition, contact, playerphoto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssssss", $surName, $middleName, $lastName, $sport, $team, $position, $contactNo, $filePath);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Success
            header("Location: PlayerRegistration.html?success=1");
            die();
        } else {
            // Error
            echo "Registration failed. Please try again.";
        }
    } else {
        echo "Error uploading image.";
        exit();
    }
} else {
    echo "Invalid request method.";
}

