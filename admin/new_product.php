<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['role'] !== 'admin' || !isset($_SESSION['role']))
    header('location:index.php');
else {
    require 'header.php';
    require '../db/dbcon.php';

    //check values
    function test($val) {
        $data = trim($val);
        $data = stripslashes($val);
        $data = htmlspecialchars($val);
        return $val;
    }

    if (isset($_POST['submit'])) {
//        variables to store form values which were submitted
        // echo '<script>alert("form submitted")</script>';.
        $name = test($_POST['product_name']);
        $brand = test($_POST['product_brand']);
        $code = $_POST['product_code'];
        $description = test($_POST['product_description']);
        $category = $_POST['category'];
        $subcategory = $_POST['subcategory'];
        $price = intval(test($_POST['unit_price']));
        $stock = intval(test($_POST['stock']));

        $sql = "select count(category) from products where category='$category'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if (intval($row[0]) < 3) {
            // directory where image will be stored
            $target_dir = "upload/" . $code;
            $ext = explode('.', basename($_FILES["image"]["name"]));
            $target_file = $target_dir . "." . end($ext);
            // echo $target_file;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file already exists
            if (file_exists($target_file)) {
                echo '<script>alert("' . $target_file . '")</script>';
                echo "Sorry, file already exists.";
            } else {
                // check and Allow certain image formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    echo "Sorry, only JPG, JPEG, PNG files are allowed.";
                } else {

                    $sql = "INSERT INTO `products`( `product_code`, `product_name`, `product_brand`, `product_description`, `category`, `subcategory`, `price`, `stock`,`image`, `added_by`) VALUES"
                            . "('$code','$name','$brand','$description','$category','$subcategory','$price','$stock','$target_file','" . $_SESSION['user'] . "')";

//                    save the image in target director
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], "../" . $target_file)) {
//                        echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
                        if (mysqli_query($conn, $sql) === TRUE) {
                            echo"<script>alert('inserted');</script>";
//                            create inventory entry for the product
                            $sql = "select max(sl) from products";
                            $result = mysqli_query($conn, $sql);
                            $product_sl = mysqli_fetch_array($result);
                            $month=date("M/Y");
                            $units=0;
                            $total_sale=0;
                            $sql="INSERT INTO `inventory`( `product_sl`, `month`, `units`, `totale_sale`) VALUES "
                                    . "('$product_sl[0]','$month','$units','$total_sale')";
                            if(mysqli_query($conn, $sql)){
                                echo"<script>alert('Inventory Updated');</script>";
                            }else echo"<script>alert('Not inserted inventory ".$conn->error."');</script>";
                            
                        } else {
                            echo"<script>alert('not inserted');</script>";
                        }
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
        } else {
            echo '<script>alert("you already have ' . $row[0] . ' products in this category. cant insert more");</script>';
        }
    }
    ?>
    <script>
        function fetch_subcategory(category) {
            // alert(category);
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {
                    serial: 1,
                    sl: category
                },
                success: function (response) {
                    document.getElementById("subcategory").innerHTML = response;
                    //                alert(response.toString());
                }
            });
        }
    </script>

    <div class="container">
        <h1 class="text-center">Add New Product</h1>
        <div class="col-sm-9 col-sm-offset-1">
            <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  enctype="multipart/form-data">
                <table class="table table-responsive">
                    <!--product name-->
                    <tr class="form-group">
                        <td><b>Product Name</b></td>
                        <td></td>
                        <td><input type="text" class="form-control" name="product_name"></td>
                    </tr>
                    <!--product brand-->
                    <tr class="form-group">
                        <td><b>Product Brand</b></td>
                        <td></td>
                        <td><input type="text" class="form-control" name="product_brand"></td>
                    </tr>
                    <!--product code-->
                    <tr class="form-group">
                        <td><b>Product Code</b></td>
                        <td></td>
                        <?php
                        $product_code = "product";
                        $sql = "select max(sl) from products";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                        if ($row[0] === NULL || $row[0] === '')
                            $product_code = $product_code . '0';
                        else
                            $product_code = $product_code . (intval($row[0]) + 1);
                        ?>
                        <td><input type="text" class="form-control" name="product_code" value="<?php echo $product_code; ?>" readonly></td>
                    </tr>
                    <!--product description-->
                    <tr class="form-group">
                        <td><b>Product Description</b></td>
                        <td></td>
                        <td><textarea class="form-control" name="product_description" rows="5"></textarea> </td>
                    </tr>
                    <!--product category-->
                    <tr class="form-group">
                        <td><b>Product Category</b></td>
                        <td></td>
                        <td>
                            <select name="category" class="form-control selectpicker" onchange="fetch_subcategory(this.value)" >
                                <option value="">Select</option>
                                <?php
                                $sql = "select * from types";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['sl'] ?>"><?php echo $row['category'] ?></option>

                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <!--product subcategory-->
                    <tr class="form-group">
                        <td><b>Product Sub-Category</b></td>
                        <td></td>
                        <td>
                            <select name="subcategory" class="form-control selectpicker" id="subcategory">

                            </select>
                        </td>
                    </tr>
                    <!--product price-->
                    <tr class="form-group">
                        <td><b>Unit Price</b></td>
                        <td></td>
                        <td><input type="number" min="0" step="0.5"  class="form-control" name="unit_price"></td>
                    </tr>
                    <!--product stock-->
                    <tr class="form-group">
                        <td><b>Stock</b></td>
                        <td></td>
                        <td><input type="number" class="form-control" name="stock" min="1" max="200"></td>
                    </tr>
                    <!--product image-->
                    <tr class="form-group">
                        <td><b>Product Image</b></td>
                        <td></td>
                        <td><input type="file" class="form-control" name="image"></td>
                    </tr>
                    <!--Add Product-->
                    <tr class="form-group">
                        <td><b></b></td>
                        <td></td>
                        <td><button type="submit" class="btn btn-warning"  name="submit">ADD Product<span class="glyphicon glyphicon-send"></span></button></td>
                    </tr>

                </table>
            </form>
        </div>
    </div>
    <?php
    require 'footer.php';
}
?>