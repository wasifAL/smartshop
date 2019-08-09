<?php

if (!isset($_SESSION))
    session_start();
if ($_SESSION['role'] !== "admin" && !isset($_SESSION['role']) && $_SESSION['role'] !== "customer") {
    header("location:../../index.php");
}
require '../db/dbcon.php';
//messages status read
if ($_GET['serial'] === "1") {
    $sql = "select count(*) from chat where to_user='admin' and status=0";
    if ($result = mysqli_query($conn, $sql)) {
        $r= mysqli_fetch_array($result);
        echo $r[0];
    }else echo $conn->error;
}
if ($_GET['serial'] === "2") {
    $sql = "select count(*) from notification where for_user='1' and from_user='order' and status=0";
    if ($result = mysqli_query($conn, $sql)) {
        $r= mysqli_fetch_array($result);
        echo $r[0];
    }else echo $conn->error;
}
?>
