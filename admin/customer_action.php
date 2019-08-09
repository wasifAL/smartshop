<?php

if (!isset($_SESSION))
    session_start();
require '../db/dbcon.php';
if ($_SESSION['role'] !== 'admin')
    header('location:index.php');
else {
     if ($_GET['kaj'] === 'update') {
        $email = $_GET['email'];
        $sl = intval($_GET['sl']);

        $sql = "UPDATE `user` SET `email`='$email' where sl=$sl";
        if (mysqli_query($conn, $sql)) {
            echo "customer_list.php";
        }
    }  
     if ($_GET['kaj'] === 'delete') {
        $sl = intval($_GET['sl']);

        $sql = "DELETE from `user` where sl=$sl";
        if (mysqli_query($conn, $sql)) {
            echo "customer_list.php";
        }
    }  
}

?>