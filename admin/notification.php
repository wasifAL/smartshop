 
<?php
//including the header area

require '../db/dbcon.php';
//check and start sesssion if not started already
if (!isset($_SESSION))
    session_start();

if (isset($_SESSION['role'])) {

    $q = "UPDATE notification SET status=1 where for_user=" . $_SESSION['user_sl'];
    mysqli_query($conn, $q);
    require 'header.php';
    
    $user_sl = $_SESSION['user_sl'];

    $q = "select * from notification where for_user=$user_sl and from_user='order' order by sl DESC";
    $r = mysqli_query($conn, $q);
    ?>
    <div class="container">
        <h2 class="text-center">Notification</h2>
        <table class="table table-responsive">
            <tr>
                <th>DATE</th>
                <th>MESSAGE</th>
            </tr>
            <?php
            $cnt = 0;
            while ($s = mysqli_fetch_assoc($r)) {
                ?>
                <tr>
                    <th><?php echo date("jS M, Y", strtotime($s['create_date'])); ?></th>
                    <th><?php echo $s['message']; ?></th>
                </tr>  
            <?php } ?>
        </table>
    </div>
    <br><br>
    <div class="navbar-fixed-bottom">
        <?php
        require 'footer.php';
        ?>
    </div>
    <?php
} else
    header("location:login.php");
?>
