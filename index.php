<?php
//wiil start session if session is not started in the document
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}
require 'header.php';
require'db/dbcon.php';
?>
<style>
    .slide-image{
        width: 100% !important;
        height: 400px !important;
        margin: 0 auto;
    }
    .product_image{
        width: 250px !important;
        height: 250px !important;
    }
</style>
<!-- Page Content -->
<div class="container">

    <!-- Jumbotron Header -->
    <header class="row">
        <div class="carousel-holder">

            <div class="col-md-12">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <img class="slide-image" src="image/13.jpg" height="300" alt="">
                        </div>
                        <div class="item">
                            <img class="slide-image" src="image/16.jpg" height="300"  alt="">
                        </div>
                        <div class="item">
                            <img class="slide-image" src="image/shop.jpg" height="300" alt="">
                        </div>

                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>

        </div>
    </header>

    <hr>

    <!-- Title -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center"><b>Latest Products</b></h2>
        </div>
    </div>
    <!-- /.row -->

    <!-- Page Features -->
    <div class="row text-center">

<?php
$sql="select * from products order by sl DESC limit 4";
if($result=mysqli_query($conn,$sql)){
    while($row=mysqli_fetch_assoc($result)){

?>
        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail">
                <img src="<?php echo $row['image'];?>" class="product_image" alt="">
                <div class="caption">
                    <h3><?php echo $row['product_name'];?></h3>
                    <p class="text-justified"><?php echo implode(" ",array_slice(explode(" ",$row['product_description']),0,10));?></p>
                    <p>
                       <a class="btn btn-primary" href="update-cart.php?id=<?php echo $row['sl']."&action=add"; ?>">Add to cart</a>

                         <a href="productview.php?id=<?php echo $row['sl'] ?>" class="btn btn-default">More Info</a>
                    </p>
                </div>
            </div>
        </div>
<?php
}
 }
else echo mysqli_error($conn);
?>

    </div>
    <!-- /.row -->

    <hr>

    <?php
    require'autoDelete.php';
    require 'footer.php';
    ?>
