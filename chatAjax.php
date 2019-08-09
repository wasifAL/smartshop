<?php

if (!isset($_SESSION))
    session_start();
if ($_SESSION['role'] !== "admin" && !isset($_SESSION['role']) && $_SESSION['role'] !== "customer") {
    header("location:../../index.php");
}
require 'db/dbcon.php';

//write message in database
if ($_GET['serial'] === "1") {
    $to = trim($_GET['to']);
    $from = trim($_GET['from']);
    $message = htmlentities(mysqli_real_escape_string($conn, trim($_GET['text'])));

    $sql = "INSERT INTO `chat`(`to_user`, `from_user`, `message`)  VALUES ('" . $to . "','" . $from . "','" . $message . "')";

    if (mysqli_query($conn, $sql)) {
//        echo "<li><p>Data Inserted " . $to . " " . $from . " " . $message . "</p></li>";
    } else {
        echo "<li><p>Data not Inserted " . $to . " " . $from . " " . $message . "</p></li>";
    }
}

//Reading messages from the database
if ($_GET['serial'] === "2") {
//     echo "<tr><th>db is empty now ".$_GET['to']." ".$_GET['from']."</th></tr>";
    $to = trim($_GET['to']);
    $from = trim($_GET['from']);
    $imageUser = '';
    $s2 = "select profile_picture from user where username='$from'";
    $r = mysqli_query($conn, $s2);
    $p2 = mysqli_fetch_array($r);
    if ($p2[0] !== NULL)
        $imageUser = $p2[0];
    else
        $imageUser = "pp/pp.jpg";
//     echo "<li><p>Data not Inserted " . $to . " " . $from . " " . $imageUser . "</p></li>";
    $sql = "select * from chat where (to_user='$to' and from_user='$from') or (to_user='$from' and from_user='$to')";
    if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['from_user'] === $from) {
                echo ' <li class="right clearfix">
                    <span class="chat-img pull-right">
                        <img src="' . $imageUser . '" alt="User Avatar" class="img-responsive img-circle" height="30" width="30" />
                    </span>
                    <div class="chat-body clearfix">
                        <div class="header">
                            <small class=" text-muted"><span class="glyphicon glyphicon-time"> ' . date("G:i", strtotime($row['message_time'])) . '</span></small>
                            <strong class="pull-right primary-font"> ' . $from . '</strong>
                        </div>
                        <p>' . $row['message'] . '</p>
                        </div></li>';
            }
             else if ($row['from_user'] === $to) {

                echo '<li class="left clearfix">
                    <span class="chat-img pull-left">
                        <img src="pp/pp.jpg" alt="User Avatar" class="img-responsive img-circle" height="30" width="30"/>
                    </span>
                    <div class="chat-body clearfix">
                        <div class="header">
                            <strong class="primary-font">' . $to . '</strong> <small class="pull-right text-muted">
                                <span class="glyphicon glyphicon-time"></span>' . date("G:i", strtotime($row['message_time'])) . '</small>
                        </div>
                        <p>' . $row["message"] . '</p></div></li>';
            }
        }
    }
}

//messages status read
if ($_GET['serial'] === "3") {
//     echo "<tr><th>db is empty now ".$_GET['to']." ".$_GET['from']."</th></tr>";
    $to = trim($_GET['to']);
    $from = trim($_GET['from']);
    $sql = "select count(*) from chat where (to_user='$from' and from_user='$to') and status=0";
    if ($result = mysqli_query($conn, $sql)) {
        $r= mysqli_fetch_array($result);
        echo $r[0];
    }
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




