<?php
require 'header.php';
require '../db/dbcon.php';

function test($val) {
    $data = trim($val);
    $data = stripslashes($val);
    $data = htmlspecialchars($val);
    return $val;
}

//add new category
if (isset($_POST['submit'])) {

    $discount = floatval(test($_POST['discount']));
    $product_sl = intval(test($_POST['product']));
    $start_date = test($_POST['start_date']);
    $end_date = test($_POST['end_date']);

    $sql = "INSERT INTO `offers`(`start_date`, `end_date`, `discount`, `product_sl`) VALUES ('$start_date','$end_date','$discount','$product_sl')";
    if (mysqli_query($conn, $sql)) {
        echo'<script>alert("New Offer Created");</script>';
        $query = "update products set offers=$discount where sl=" . $product_sl;
        if (mysqli_query($conn, $query)) {
            echo'<script>alert("Products Updated");</script>';
        } else
            echo'<script>alert(" Error 2 :' . mysqli_error($conn) . '");</script>';
    } else
        echo'<script>alert("Error 1 :' . mysqli_error($conn) . '");</script>';
}
?>
<style>
    .table tr th,.table  tr td{
        border-top: unset !important;
    }
</style>

<script>
    $(document).ready(function () {
        $("#add_new").hide();
        $("#cancel").hide();
        $("#new").click(function () {
            $(this).hide();
            $("#add_new").show();
            $("#cancel").show();
        });
        $("#cancel").click(function () {
            $(this).hide();
            $("#new").show();
            $("#add_new").hide();
        });
    });
</script> 
<?php
if (isset($_GET['action'])) {
//   delete category
    if ($_GET['action'] === 'delete') {
        $sl = $_GET['sl'];
        $product_sl = $_GET['product_sl'];

        $sql = "update products set offers='' where sl=" . $product_sl;
        if (mysqli_query($conn, $sql)) {
            echo'<script>alert("Products Updated");</script>';
            $sql="delete from offers where sl=".$sl;
            if (mysqli_query($conn, $sql)) {
                echo'<script>alert("Offer Deleted");</script>';                
            } else
                echo'<script>alert("' . mysqli_error($conn) . '");</script>';
        } else
            echo'<script>alert("' . mysqli_error($conn) . '");</script>';
    }
    ?>

    <?php
}
$sql = "select * from offers";
$result = mysqli_query($conn, $sql);
?>
<div class="container">
    <div class="col-sm-8 col-sm-offset-2">
        <h2 class="text-center">Offers</h2>
        <button class="btn btn-sm btn-info" id="new">Add New</button>
        <button class="btn btn-sm btn-danger" id="cancel">Cancel</button>
        <!--Create new offer-->
        <form class="form-horizontal" id="add_new" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table class="table table-responsive">
                <tr class="">
                    <td><b>Discount</b></td>
                    <td></td>
                    <td><input type="number" class="form-control" min="0" max="100" name="discount" required></td>
                </tr>
                <?php
                $q = "select * from products where offers = ''";
                $f = true;
                if ($r = mysqli_query($conn, $q)) {
                    
                } else
                    $f = false;
                ?>
                <tr class="">
                    <td><b>Product Code</b></td>
                    <td></td>
                    <td>
                        <select class="form-control selectpicker" name="product" required>
                            <?php
                            if ($f === false) {
                                echo"<option value=''>No Product Found</option>";
                            } else {
                                while ($x = mysqli_fetch_assoc($r)) {
                                    ?>
                                    <option value="<?php echo $x['sl'] ?>"><?php echo $x['product_code'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>              
                <tr>
                    <th>Start Date</th>
                    <td></td>
                    <td><input type="date" name="start_date" class="form-control" min="<?php echo date("Y-m-d"); ?>" required></td>
                </tr>
                <tr>
                    <th>End Date</th>
                    <td></td>
                    <td><input type="date" name="end_date" class="form-control" min="<?php echo date("Y-m-d"); ?>" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><input type="submit" name="submit" class="btn btn-success" value="Create"></td>
                </tr>
            </table>            
        </form>
        <!--show the running offers-->
        <table class="table table-responsive">
            <tr class="text-center">
                <td><b>sl</b></td>
                <td><b>Product</b></td>
                <td><b>Discount</b></td>
                <td><b>Start Date</b></td>
                <td><b>End Date</b></td>
                <td><b>Action</b></td>
            </tr>
            <?php
            $c = 0;
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo ++$c; ?></td>
                    <td><?php
            $query = "select product_code from products where sl=" . $row['product_sl'];
            $r = mysqli_query($conn, $query);
            $s = mysqli_fetch_array($r);
            echo $row[0];
                ?></td>
                    <td><?php echo $row['discount']; ?></td>
                    <td><?php echo $row['start_date'] ?></td>
                    <td><?php echo $row['end_date'] ?></td>
                    <td>
                        <a class="btn btn-danger" href="offer.php?<?php echo "sl=" . $row['sl'] . "&action=delete&product_sl=" . $row['product_sl']; ?>">DELETE</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

