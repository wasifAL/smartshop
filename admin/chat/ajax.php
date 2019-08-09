<?php

if (!isset($_SESSION))
    session_start();
if ($_SESSION['role'] !== "admin" && !isset($_SESSION['role'])) {
    header("location:../../index.php");
}
require '../../db/dbcon.php';

//write message in database
if ($_GET['serial'] === "1") {
    $to = trim($_GET['to']);
    $from = trim($_GET['from']);
    $message = htmlentities(mysqli_real_escape_string($conn, trim($_GET['text'])));
    $sql = "INSERT INTO `chat`(`to_user`, `from_user`, `message`)  VALUES ('" . $to . "','" . $from . "','" . $message . "')";

    if (mysqli_query($conn, $sql)) {
        echo "<tr><th>Data Inserted " . $to . " " . $from . " " . $message . "</th></tr>";
    } else {
        echo "<tr><th>Data not Inserted " . $to . " " . $from . " " . $message . "</th></tr>";
    }
}



//Reading messages from the database
if ($_GET['serial'] === "2") {
//     echo "<tr><th>db is empty now ".$_GET['to']." ".$_GET['from']."</th></tr>";
    $to = trim($_GET['to']);
    $from = trim($_GET['from']);
    $sql = "select * from chat where (to_user='$to' and from_user='$from') or (to_user='$from' and from_user='$to')";
    if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['from_user'] === $from) {
                echo"<tr><td class='text-right'>" .
                "<p>" . $row['message'] . "<br>" .
                "" . date("G:i", strtotime($row['message_time'])) . "</p>"
                . "</td></tr>";
            } else if ($row['from_user'] === $to) {
                echo"<tr><td>" .
                "<p>" . $row['message'] . "<br>" .
                "" . date("G:i", strtotime($row['message_time'])) . "</p>"
                . "</td></tr>";
            }
        }
    }
}
//calling userlist from database
if ($_GET['serial'] === "3") {
   
}
//messages status reset
if ($_GET['serial'] === "4") {
     
    $to = trim($_GET['to']);
    $from = trim($_GET['from']);
    $sql = "UPDATE `chat` SET status=1 where (to_user='$from' and from_user='$to') and status=0";
    mysqli_query($conn, $sql);
    echo"0";
}
?>

