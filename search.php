<?php
require'header.php';
require'db/dbcon.php';
?>


<script type="text/javascript">
    $(document).ready(function () {
        $("#serch_suggestion").hide();
        $("#search_text").focusin(function () {
            $("#serch_suggestion").show();
        });
        $("#search_text").focusout(function () {
            setTimeout(function () {
                $("#serch_suggestion").hide();
            }, 80);

        });

        function searchAction() {
            var text = $("#search_text").val();
            $.get("searchAction.php", {
                serial: 1,
                text: text
            }, function (data) {
                $("#serch_suggestion").html(data);
            });
        }

        $("#search_text").keypress(function () {
            setTimeout(function () {
                searchAction();
            }, 100);
        });

    });
</script>



<div class="container">
    <form>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" id="search_text">
            <div class="input-group-btn">
                <a class="btn btn-default" id="search">
                    <i class="glyphicon glyphicon-search"></i>
                </a>
            </div>
        </div>
    </form>
    <div class="well" id="serch_suggestion">

    </div><br><br>


    <?php
    if (isset($_GET['search'])) {
        $message = htmlentities(mysqli_real_escape_string($conn, trim($_GET['search'])));
        $sql = "Select * from products where product_name like '%" . $message . "' or product_name like '" . $message . "%' or product_brand like '%" . $message . "' or product_brand like '" . $message . "%'";
        if ($x = mysqli_query($conn, $sql)) {
            ?>

            <table class="table table-responsive">
                <tr>
                    <th>No.</th>
                    <th>Photo</th>
                    <th>Product Name</th>
                    <th>Product Brand</th>
                    <th>Product Description</th>
                    <th>Category</th>
                    <th>Sub-Category</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                <?php
                $c = 0;
                while ($y = mysqli_fetch_assoc($x)) {
                    ?>
                    <tr>
                        <td><?php echo ++$c; ?></td>
                        <td><img src="<?php echo $y['image']; ?>" class="img-responsive" height="60" width="60"></td>
                        <td><?php echo $y['product_name']; ?></td>
                        <td><?php echo $y['product_brand']; ?></td>
                        <td><textarea class="form-control" rows="4" cols="40"><?php echo $y['product_description']; ?></textarea></td>
                        <td><?php
                            $sql = "select category from types where sl=" . $y['category'];
                            $s = mysqli_query($conn, $sql);
                            $r = mysqli_fetch_array($s);
                            echo $r[0];
                            ?></td>
                        <td><?php echo $y['subcategory']; ?></td>
                        <td><?php echo $y['stock']; ?></td>
                        <td><?php echo $y['price']; ?></td>
                        <td>
                            <a class="btn btn-info" href="update-cart.php?id=<?php echo $y['sl'] . "&action=add"; ?>">Add to Cart</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>



            </table>
        </div>




        <?php
    } else {
        echo "<h1>No Products Found with this keyword.</h2>";
    }
}
?>
<div class="navbar-fixed-bottom">
    <?php
    require'footer.php';
    ?>
</div>