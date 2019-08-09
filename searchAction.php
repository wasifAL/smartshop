<?php

if (!isset($_SESSION))
    session_start();
if ($_SESSION['role'] !== "admin" && !isset($_SESSION['role']) && $_SESSION['role'] !== "customer") {
    header("location:../../index.php");
}
require 'db/dbcon.php';

//write message in database
if ($_GET['serial'] === "1") {
    $message = htmlentities(mysqli_real_escape_string($conn, trim($_GET['text'])));
    $sql = "Select * from products where product_name like '%" . $message . "' or product_name like '" . $message . "%' "
            . "or product_brand like '%" . $message . "' or product_brand like '" . $message . "%'";
    if ($x = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($x) > 0) {
            while ($z = mysqli_fetch_assoc($x)) {
                echo "<a class='btn-block' href='search.php?search=" . $z['product_name'] . "'>" . $z['product_name'] . "</a>";
            }
        }else echo'Sorry!! No Product Found';
    } else {
        echo mysqli_error($conn);
    }
}
?>

