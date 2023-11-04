<?php
$servername = "localhost";
$username = "root";
$password = "MOHAmed.@98765";
$dbname = "makeover";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
