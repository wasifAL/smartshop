<?php
//wiil start session if session is not started in the document
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}
require 'header.php';
require'db/dbcon.php';
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

    <div class="row">
        <div class="col-md-3">
            <p class="lead">Smart Shop</p>
            <div class="list-group">
                <?php
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


            <?php
            $sql = "select * from products where sl=" . $_GET['id'];
            if ($result = mysqli_query($conn, $sql)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="thumbnail">
                        <img class="img-responsive" src="<?php echo $row['image'] ?>" alt="">
                        <div class="caption-full">
                            <h4 class="pull-right">
                                 <?php
                                        if(floatval($row['offers'])>0){
                                            $current= floatval($row['price'])-(floatval($row['price'])*(floatval($row['offers'])/100));
                                            echo '<s style="font-size:12px">$'.$row['price'].'</s><br>$'.$current;
                                        }else
                                        echo "$".$row['price']; ?>
                            </h4>
                            <h4><a href="#"><?php echo $row['product_name']; ?></a></h4>
                            <h3><a href="search.php?brand=<?php echo $row['product_brand']; ?>"><?php echo $row['product_brand']; ?></a></h3>
                            <p class="text-justified"><?php echo $row['product_description']; ?></p>
                            <p>
                               <a class="btn btn-primary" href="update-cart.php?id=<?php echo $row['sl']."&action=add"; ?>">Add to cart</a>
                                         </p>
                        </div>
                    </div>
                    <?php
                }
            } else
                echo mysqli_error($conn);
            ?>



        </div>

    </div>

</div>
<!-- /.container -->

<?php
require 'footer.php';
?>