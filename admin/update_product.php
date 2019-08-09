<?php

if (!isset($_SESSION))
    session_start();
require '../db/dbcon.php';
if ($_SESSION['role'] !== 'admin')
    header('location:index.php');
else {

    if ($_GET['kaj'] === 'update') {
        $price = floatval($_GET['price']);
        $stock = intval($_GET['stock']);
        $sl = intval($_GET['sl']);

        $sql = "UPDATE `products` SET `price`='$price', `stock`='$stock' where sl=$sl";
        if (mysqli_query($conn, $sql)) {
            echo "view_product.php";
        }
    }
    if ($_GET['kaj'] === 'delete') {
        $sl = intval($_GET['sl']);
        $sql = "DELETE FROM `inventory` WHERE `product_sl`=$sl";
        if (mysqli_query($conn, $sql)) {
            $sql = "SELECT * FROM `products` WHERE `sl`=$sl";
            $x = mysqli_query($conn, $sql);
            $z = mysqli_fetch_assoc($x);
            unlink("../" . $z['image']);
            $sql = "DELETE FROM `products` WHERE `sl`=$sl";
            if (mysqli_query($conn, $sql)) {
                echo "view_product.php";
            }
        }
    }
}
?>

