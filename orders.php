
<?php
//including the header area
require 'header.php';
require 'db/dbcon.php';
//check and start sesssion if not started already
if (!isset($_SESSION))
    session_start();

if (isset($_SESSION['role'])) {    
    $result=$conn->query("select * from user where username='".$_SESSION['user']."' and role='".$_SESSION['role']."'");
    $r= mysqli_fetch_assoc($result);
    $user_sl=$r['sl'];
    
    $q="select * from orderlist where user_sl='$user_sl'";
    $r= mysqli_query($conn, $q);
    
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
        </tr>
        <?php
        $cnt=0;
        while($s=mysqli_fetch_assoc($r)){
        ?>
        <tr>
            <td><?php echo ++$cnt;?></td>
            <td><?php echo $s['order_id'];?></td>
            <td><?php echo $s['product_sl'];?></td>
            <td><?php echo $s['units'];?></td>
            <td><?php echo $s['total_cost'];?></td>
            <td><?php echo date("jS M, Y",strtotime($s['order_date']));?></td>
            <td><?php echo date("jS M, Y",strtotime($s['delivery_date']));?></td>
        </tr>
        <?php }?>
    </table>
</div>



<?php }else header("location:login.php"); ?>
