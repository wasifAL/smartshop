<?php

require 'db/dbcon.php';
// offers processing
$date = date("Y-m-d", strtotime(date("Y-m-d") . "-1 days"));
// calling all offer datas
$sql = "SELECT * from `offers`";
// checking sql execution
if ($r = mysqli_query($conn, $sql)) {
    // parsing the result for all row
    while ($r1 = mysqli_fetch_assoc($r)) {
        // formating received date
        $d1 = date("Y-m-d", strtotime($r1['end_date']));
        // checking date value
        if ($date === $d1) {
            // update the product table
            $sql = "UPDATE products SET offers=0 where sl=" . $r1['product_sl'];
            if (mysqli_query($conn, $sql)) {
                // delete the offer
                $sql = "DELETE from offers where sl=" . $r1['sl'];
                if (mysqli_query($conn, $sql)) {
                    // echo " SUCCESSFUL";
                }
            }
        }
    }
}

// order processing
$sql = "SELECT * from orderlist";
if ($r = mysqli_query($conn, $sql)) {
    while ($orders = mysqli_fetch_assoc($r)) {
        $date = date("Y-m-d", strtotime(date("Y-m-d") . "+1 days"));
        $d1 = date("Y-m-d", strtotime($orders['delivery_date']));
        if ($date === $d1) {
            echo"next day notice<br>";
            if ($orders['delivery_status'] === '0') {
                $message = "This order" . $orders['order_id'] . " is not delivered yet. last date of delivery is " . $date . " Please check.";
                $noti = $conn->query("INSERT INTO `notification`(`for_user`, `from_user`, `message`, `create_date`, `destroy_date`, `status`) VALUES"
                        . "('1','order','" . $message . "','" . date("Y-m-d") . "','" . date('Y-m-d', strtotime(date('Y-m-d') . '+2 days')) . "','0')");
                echo $message;
            }
        }
        $date = date("Y-m-d", strtotime(date("Y-m-d") . "-0 days"));
        if ($date === $d1) {
//            echo"passed day notice<br>";
            if ($orders['delivery_status'] === '0') {
                $message = "This order " . $orders['order_id'] . " is not delivered yet. last date of delivery is passed Please check.";
                $noti = $conn->query("INSERT INTO `notification`(`for_user`, `from_user`, `message`, `create_date`, `destroy_date`, `status`) VALUES"
                        . "('1','order','" . $message . "','" . date("Y-m-d") . "','" . date('Y-m-d', strtotime(date('Y-m-d') . '+2 days')) . "','0')");
//                echo $message;
            } else {
                $sql = "DELETE from orderlist where order_id='" . $orders['order_id'] . "'";
                if (mysqli_query($conn, $sql)) {
//                    echo " Successfully deleted";
                }
//                    echo $conn->error;
            }
        }
    }
}
$sql = "SELECT * FROM `notification`";
if ($r = mysqli_query($conn, $sql)) {
    while ($x = mysqli_fetch_assoc($r)) {
        $date = date("Y-m-d", strtotime(date("Y-m-d")));
        $d1 = date("Y-m-d", strtotime($x['destroy_date']));
        if ($date === $d1) {
            $sql = "DELETE from notification where sl='" . $x['sl'] . "'";
            if (mysqli_query($conn, $sql)) {
                echo "deleted notices";
            }
        }
    }
}
?>
