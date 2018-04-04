<?php
//including the header area
require 'header.php';
require 'db/dbcon.php';
//check and start sesssion if not started already
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['role'])) {?>

<?php }else header("location:shop.php"); ?>
