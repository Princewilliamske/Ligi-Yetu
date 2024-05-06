<?php
//  Connecting to Database 
$con = mysqli_connect("localhost","root","","league_management_system");

if(!$con){
echo "database connection failed";
}
