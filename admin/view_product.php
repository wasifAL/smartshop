<?php
if (!isset($_SESSION))
    session_start();
if ($_SESSION['role'] !== 'admin' || !isset($_SESSION['role']))
    header('location:index.php');
else {
    require 'header.php';
    require '../db/dbcon.php';

    $sql = "select * from products";
    if ($result = mysqli_query($conn, $sql)) {
        
    } else
        echo "<script>alert(" . mysqli_errno($conn) . ");</script>";
    $c = 0;
    ?>

    <script type="text/javascript">
        function update(cod, act) {
            document.getElementById("price").value = ".price" + cod;
            document.getElementById("stock").value = ".stock" + cod;
            document.getElementById("action").value = act;
            document.getElementById("sl").value = cod;
        }
        function del(cod, act) {
            document.getElementById("action").value = act;
            document.getElementById("sl").value = cod;
        }

        $(document).ready(function () {
            $(".x").attr("readonly", "true");
            $(".btn-info").hide();
            var $price = "";
            var $stock = "";
            var $action = "";
            var $sl = "";

            $(".delete").click(function () {
                setTimeout(function () {
                    $action = document.getElementById("action").value;
                    $sl = document.getElementById("sl").value;
                    alert($action+" "+$sl);
                    $.get("update_product.php", {
                        kaj: $action,
                        sl: $sl,
                    }, function (data) {
                        //                            when product is success fully deleted
                        alert("Product Deleted Successfully");
                        window.location.replace(data);
                    });
                }, 200);
            });

            //updating a product details 
            $(".update").click(function () {
                $(".x").attr("readonly", "true");
                $(".btn-info").hide();
                $(this).hide();
                setTimeout(function () {
                    $action = document.getElementById("action").value;
                    $price = document.getElementById("price").value;
                    $stock = document.getElementById("stock").value;
                    $sl = document.getElementById("sl").value;

                    //change the button and input fields condition for updating

                    $($action).show();
                    $($price).removeAttr("readonly");
                    $($stock).removeAttr("readonly");
                    //                    when update submitted
                    $($action).click(function () {
                        var $dam = $($price).val();
                        var $gudam = $($stock).val();
                        if ($gudam < 201 && $gudam > -1 && $dam > 0) {
                            //                        alert($dam + " " + $gudam + " " + $sl);                        
                            //
                            //ajax call for updating product price and stock
                            $.get("update_product.php", {
                                kaj: 'update',
                                sl: $sl,
                                price: $dam,
                                stock: $gudam
                            }, function (data) {
                                //                            when product is success fully updated
                                alert("Product Updated");
                                window.location.replace(data);
                            });
                        } else {
                            alert("Stock Can't be Negative or more than 200 and price can't be 0");
                        }
                    });
                }, 200);
            });


        });



    </script>
    <div class="container-fluid">
        <table class="table table-responsive table-hover">
            <tr>
                <th>sl</th>
                <th>Code</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Description</th>
                <th>Category</th>
                <th>Sub-Category</th>
                <th>Price($)</th>
                <th>Stock</th>
                <th>Added By</th>
                <th>Add Date</th>
                <th>Action</th>
            </tr>
            <tr>
            <input type="hidden" id="price">
            <input type="hidden" id="stock">
            <input type="hidden" id="action">
            <input type="hidden" id="sl">
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="row<?php echo $row['sl']; ?>">
                    <td><?php echo ++$c; ?></td>
                    <td><?php echo $row['product_code']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['product_brand']; ?></td>
                    <td><textarea class="form-control" rows="4" cols="40"><?php echo $row['product_description']; ?></textarea></td>
                    <td><?php
                        $sql = "select category from types where sl=" . $row['category'];
                        $s = mysqli_query($conn, $sql);
                        $r = mysqli_fetch_array($s);
                        echo $r[0];
                        ?></td>
                    <td><?php echo $row['subcategory']; ?></td>
                    <td><input type="text" class="form-control price<?php echo $row['sl']; ?> x" value="<?php echo $row['price']; ?>"></td>
                    <td><input type="number" max="200" min="0" class="form-control stock<?php echo $row['sl']; ?> x" value="<?php echo $row['stock']; ?>"></td>
                    <td><?php echo $row['added_by']; ?></td>
                    <td> <?php echo date('d-M, Y', strtotime($row['add_date'])); ?></td>
                    <td>
                        <a href="javascript:update(<?php echo $row['sl']; ?>,'.update<?php echo $row['sl']; ?>')" class="btn btn-warning update" >Update</a>
                        <a href="#" class="btn btn-info update<?php echo $row['sl']; ?>" >Update</a>
                        <a href="javascript:del(<?php echo $row['sl']; ?>,'delete')" class="btn btn-danger delete">Delete</a>
                    </td>
                </tr>
            <?php } ?>

        </table>
    </div>
    <?php
    require 'footer.php';
}
?>