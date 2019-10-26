<?php
/*

connect.php

Set SQL server/user/password/database information.



*/


$servername = "127.0.0.1";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
