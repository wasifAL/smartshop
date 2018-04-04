<?php

$dbName="smartshop";
$dbUser="root";
$dbPass="";
$hostName="localhost";

$conn = new mysqli($hostName, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
