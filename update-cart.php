<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if(session_id() == '' || !isset($_SESSION)){session_start();}
include 'db/dbcon.php';

if(isset($_GET)){
$product_id = $_GET['id'];
$action = $_GET['action'];
}

//echo '<script>alert("'.$product_id.' '.$action.'" )</script>';
if($action === 'empty')
  unset($_SESSION['cart']);

$result = $conn->query("SELECT stock FROM products WHERE sl = ".$product_id);


if($result){
// echo '<script>alert("got product stock")</script>';
  if($row = $result->fetch_object()) {
// echo '<script>alert("enetered cart area")</script>';
    switch($action) {

      case "add":
      if($_SESSION['cart'][$product_id]+1 <= $row->stock)
        $_SESSION['cart'][$product_id]++;
      break;

      case "remove":
      $_SESSION['cart'][$product_id]--;
      if($_SESSION['cart'][$product_id] == 0)
        unset($_SESSION['cart'][$product_id]);
        break;
    }
  }
}
header("location:cart.php");


?>
