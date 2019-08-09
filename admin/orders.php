
<?php
//including the header area
require 'header.php';
require '../db/dbcon.php';
//check and start sesssion if not started already
if (!isset($_SESSION))
    session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] === "admin") {
    if(isset($_GET['update'])){
        $order_id=$_GET['update'];
        $sql="UPDATE `orderlist` SET `delivery_status`=1 WHERE `order_id`='$order_id'";
        if(mysqli_query($conn, $sql)){            
//            echo'<script>alert("The Order '.$order_id.' is De" )</script>';
             $message = "This order '" . $order_id . "' is delivered on ".date("jS M,Y").". If you have any further query contact the admin.";
             $noti = $conn->query("INSERT INTO `notification`(`for_user`, `from_user`, `message`, `create_date`, `destroy_date`, `status`) VALUES"
                        . "('1','order','" . $message . "','".date("Y-m-d")."','".date('Y-m-d',strtotime(date('Y-m-d') . '+2 days'))."','0')");
//         echo $message;       
        }
    }
    
    if (isset($_GET['user'])) {        
        $user_sl = $_GET['user'];
        $q = "select * from orderlist where user_sl='$user_sl' order by sl DESC";
    } else {
        $q = "select * from orderlist where delivery_status=0";
    }
    $r = mysqli_query($conn, $q);
    ?>
    <div class="container">
        <h2 class="text-center">My Orders</h2>
        <table class="table table-responsive">
            <tr>
                <th>SL</th>
                <th>Order ID</th>
                <th>Product ID</th>
                <th>Units</th>
                <th>Cost</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
                <th>Deliver Status</th>
            </tr>
    <?php
    $cnt = 0;
    while ($s = mysqli_fetch_assoc($r)) {
        ?>
                <tr>
                    <td><?php echo ++$cnt; ?></td>
                    <td><?php echo $s['order_id']; ?></td>
                    <td><?php echo $s['product_sl']; ?></td>
                    <td><?php echo $s['units']; ?></td>
                    <td><?php echo $s['total_cost']; ?></td>
                    <td><?php echo date("jS M, Y", strtotime($s['order_date'])); ?></td>
                    <td><?php echo date("jS M, Y", strtotime($s['delivery_date'])); ?></td>
                    <td><?php
        if ($s['delivery_status'] == 0) {
            echo" <a href='orders.php?update=" . $s['order_id'] . "' class='btn btn-info'>Update</a>";
        } else
            echo" Product Delivered";
        ?></td>
                </tr>
                    <?php } ?>
        </table>
    </div>



<?php } else header("location:../index.php"); ?>
