<?php
//wiil start session if session is not started in the document
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}
include'autoDelete.php';
require 'header.php';
require 'db/dbcon.php';

//if(isset($_GET['category'])) echo '<script>alert("'.$_GET['category'].'")</script>';
?>
<style>
    .product_image{
        width: 250px !important;
        height: 250px !important;
    }
</style>
<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-md-3">
            <p class="lead">Smart Shop</p>
            <div class="list-group">
                <?php
//                calls all categories from the database and shows
                $sql = "select * from types order by category ASC";
                if ($res = mysqli_query($conn, $sql)) {
                    while ($row = mysqli_fetch_array($res)) {
                        ?>
                        <a href="shop.php?category=<?php echo $row[0]; ?>" class="list-group-item"><?php echo $row[1]; ?></a>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div class="col-md-9">

            <div class="row">
                <?php
//                checking if any category was sent from previous page 
                if (isset($_GET['category'])) {
                    $sql = "select * from products where category='" . $_GET['category'] . "'and stock > 0 order by sl DESC limit 6";
                } else {
                    $sql = "select * from products where stock > 0 order by sl DESC limit 6";
                }
//showing the query result
                if ($pros = mysqli_query($conn, $sql)) {
                    while ($row = mysqli_fetch_assoc($pros)) {
                        ?>
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="thumbnail">
                                <img src="<?php echo $row['image']; ?>" alt="" class="product_image">
                                <div class="caption">
                                    <h5 class="pull-right">
                                        <?php
                                        // Offer calculation for  price of products
                                        if (floatval($row['offers']) > 0) {
                                            $current = floatval($row['price']) - (floatval($row['price']) * (floatval($row['offers']) / 100));
                                            echo '<s style="font-size:12px">$' . $row['price'] . '</s><br>$' . $current;
                                        } else
                                            echo "$" . $row['price'];
                                        ?>
                                    </h5>
                                    <h4><a href="#"><?php echo $row['product_name']; ?></a>
                                    </h4>
                                    <p>
                                        <?php ?>
                                        <a class="btn btn-primary" href="update-cart.php?id=<?php echo $row['sl'] . "&action=add"; ?>">Add to cart</a>
                                        <?php ?>
                                        <a href="productview.php?id=<?php echo $row['sl'] ?>" class="btn btn-default">More Info</a>
                                    </p>
                                </div>

                            </div>
                        </div>

                        <?php
                    }
                } else
                    echo "<script>alert(" . mysqli_error($conn) . ");</script>";
                ?>

            </div>

        </div>

    </div>

</div>
<!-- /.container -->

<div class="container">

    <hr>
    <?php require'footer.php'; ?>
