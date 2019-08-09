<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}
include 'db/dbcon.php';

// check cart status if there's any value or not
if (isset($_SESSION['cart'])) {
    $total = 0;
    $message = 'Dear ';
    $user = $_SESSION["user"];
    $message = $message . " " . $user . ", thank you for using our online shop. You have successfully order the below items : <br>";
    $m2 = "";
    // retrieving user serial from user table
    $sq = "select sl from user where username = '" . $_SESSION['user'] . "' and role='" . $_SESSION['role'] . "'";
    if ($r = mysqli_query($conn, $sq)) {
        $x = mysqli_fetch_array($r);
        $user_sl = intval($x[0]);
    }
    // formating dates
    $order_date = date('Y-m-d');
    $delivery_date = date('Y-m-d', strtotime($order_date . "+7 days"));
    $delivery_status = 0;
//for order id fetching maximum sl value    
    $row = mysqli_fetch_array($conn->query("select max(sl) from orderlist"));
    $row[0] ++;
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $result = $conn->query("SELECT * FROM products WHERE sl = '" . $product_id . "'");
        if ($result) {
            if ($obj = $result->fetch_object()) {
                $cost = $obj->price * $quantity;
                if ($obj->offers === '') {
                    $cost = $obj->price * $quantity; //work out the line cost
                } else {
                    $cost = $obj->price * $quantity; //work out the line cost
                    $cost = $cost - ($cost * (floatval($obj->offers) / 100));
                }
//
                $m2 = "Order Date : " . $order_date . " "
                        . "Delivery Date : " . $delivery_date . " "
                        . "Order ID :  " . "order" . $row[0] . " "
                        . "Product SL : " . $obj->product_name . " "
                        . "Cost : " . $cost . " "
                        . "Units : " . $quantity . "<br>";


                $query = $conn->query("INSERT INTO `orderlist`(`order_id`, `product_sl`, `user_sl`, `delivery_date`, `delivery_status`, `order_date`, `units`,`total_cost`) "
                        . "VALUES('order" . $row[0] . "', '$obj->sl', '" . $user_sl . "', '$delivery_date','$delivery_status', '$order_date',$quantity,$cost)");
                if ($query) {

                    $newqty = $obj->stock - $quantity;
                    if ($conn->query("UPDATE products SET stock= '" . $newqty . "' WHERE sl = '" . $product_id . "'")) {
//user notification
                        $noti = $conn->query("INSERT INTO `notification`(`for_user`, `from_user`, `message`, `create_date`, `destroy_date`, `status`) VALUES"
                                . "('$user_sl','system','" . $message . $m2 . "','$order_date','$delivery_date','$delivery_status')");
//admin notification
                        $message = "There is a new order from " . $user . ".The details is here : " . $m2;
                        $noti = $conn->query("INSERT INTO `notification`(`for_user`, `from_user`, `message`, `create_date`, `destroy_date`, `status`) VALUES"
                                . "('1','order','" . $message . $m2 . "','$order_date','$delivery_date','0')");

                        $inv = mysqli_query($conn, "select * from inventory where  `product_sl`=" . $product_id . " and month='" . date("M/Y") . "'");
                        if (!$inv)
                            echo $conn->error;
                        if (mysqli_num_rows($inv) === 0) {
//                           insert
                            $ins = $conn->query("INSERT INTO `inventory`(`product_sl`, `month`, `units`, `totale_sale`) VALUES ('$product_id','" . date("M/Y") . "','$quantity','$cost')");
                            if ($ins)
                                echo "new inventory created";
                            else
                                echo $conn->error;

                            unset($_SESSION['cart']);
                        } else {
                            $r = mysqli_fetch_assoc($inv);
                            $units = intval($r['units']) + $quantity;
                            $total = floatval($r['totale_sale']) + $cost;
                            $upd = $conn->query("UPDATE `inventory` SET `units` ='$units',`totale_sale`='$total' where  `product_sl`='" . $product_id . "' and `month`='" . date("M/Y") . "'");
                            if ($upd)
                                echo"inventory updated";
                            else
                                echo $conn->error;

                            unset($_SESSION['cart']);
                        }
                    }
                }
            }
        }
    }
} else
    echo "cart empty";


header("refresh=5;url=orders.php");
?>
