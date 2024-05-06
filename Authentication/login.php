<?php

include("connection.php");
include("functions.php");
session_start();              // Start/resume THIS session
$id=$_SESSION['userID'];       // Get the user's ID from this session (if it exists)
                               // If no session, then false

// Check if we have a valid user logged in
if ($id===false){
    header('Location: signup.html');
}
     // Check if user has clicked on the POST button
     if($_SERVER['REQUEST_METHOD'] == "POST")
     {
         // something was posted
         $email = $_POST['email'];
         $password = $_POST['password'];
          
         if(!empty($email) && !empty($password))
         {
            
          try {
            $stmt = mysqli_prepare($con, "SELECT * FROM users WHERE email=?");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
          
            $user_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
          
            if (!empty($user_data)) {

              if ($password === $user_data['password']) {

                session_start(); // Start session 
                session_regenerate_id(true);
                // Store user ID securely (consider encryption or a salted hash)
                 $_SESSION['user_id'] = base64_encode($user_data['user_id']);
                 header("Location: ../main.html");
                 exit();

              } else {
                // Login failed (incorrect password)
                echo "incorrect password";
              }
            } else {
              // Login failed (username not found)
              echo "Email not found!";

            }
          
            mysqli_stmt_close($stmt); // Close the prepared statement
          } catch (mysqli_sql_exception $e) {
            echo "Database error: " . $e->getMessage();
          }
          
        }
      }
      mysqli_close($con);
      ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        /* Inline CSS for demonstration */
        body {
            background-color: #8FBC8F; /* Green background */
            font-family: Arial, sans-serif;
            margin: 0; /* Reset default margin */
            padding-top: 50px; /* Add padding-top to compensate for fixed navbar */
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            background-color: #333;
            padding: 10px 0;
            z-index: 999; /* Ensure the navbar is above other elements */
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border: 1px solid green;
            border-radius: 5px;
            padding: 10px;
        }
        .login-form {
            background-color: white;
            max-width: 300px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top:600px;
        }
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 5px;
            margin: 10px 0;
            border: 1px solid grey;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .signup{
            margin-left:20px;
        }
        section{
            width:100%;
            height:550px;
            margin-top: 60px; /* Add margin-top to create space between navbar and sections */
        }
        p{
            margin-top:50px;
            font-size:30px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#announcement">Announcement</a>
        <a href="#login">Login</a>
        <a href="#signup">Sign Up</a>
    </div>

                <p>Welcome to Ligi Yetu</p>

    <section id="login">
        <div class="login-form">
            <form  method="post">
                <label for="username">Email:</label><br>
                <input type="text" id="email" name="email" required><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br>
                <input type="submit" value="Login" onclick="validate()">
                <a class="signup" href="">Doesn't have an account?</a>
            </form>
            <script>
                function validate(){
                    var email = document.getElementById("email").value;
                    var password = document.getElementById("password").value;
                    
                    if(email == "" || password == "") {
                        alert("Please fill out all fields");
                        return false;
                    } else {
                        return true;
                    } 
                }
            </script>
        </div>
    </section>

    <div class="footer">
        &copy; 2024 Ligi yetu. All rights reserved.
    </div>

</body>
</html>
