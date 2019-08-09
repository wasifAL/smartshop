<?php
require 'header.php';
require '../db/dbcon.php';

function test($val) {
    $data = trim($val);
    $data = stripslashes($val);
    $data = htmlspecialchars($val);
    return $val;
}
$category=$subcategory="";
//add new category
if (isset($_POST['submit'])) {
    $category = test($_POST['category']);
    $subcategory = test($_POST['subcategory']);
if(!empty($category)||!empty($subcategory)){
    $sql = "insert into types (category,subcategory) VALUES ('$category','$subcategory')";
    if (mysqli_query($conn, $sql))
        echo'<script>alert("New Category Added");</script>';
    else
        echo'<script>alert("' . mysqli_error($conn) . '");</script>';
}else{
    echo'<script>alert("Category or Sub-Category Not Inserted. Can not be empty");</script>';
}

}
//update category
if (isset($_POST['update'])) {
    $category = test($_POST['category']);
    $subcategory = test($_POST['subcategory']);
    $id=$_POST['id'];
     $sql = "update types set category='$category',subcategory='$subcategory' where sl=$id";
    if (mysqli_query($conn, $sql))
        echo'<script>alert("Category Updated");</script>';
    else
        echo'<script>alert("' . mysqli_error($conn) . '");</script>';
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
        $sql = "delete from types where sl=$sl";
        if (mysqli_query($conn, $sql)) {
            echo'<script>alert("Category DELETED");</script>';
            header("location:category.php");
        } else
            echo'<script>alert("' . mysqli_error($conn) . '");</script>';
    }
//    update category
    if ($_GET['action'] === 'update') {
        $sl = $_GET['sl'];
        $sql = "select * from types where sl=$sl";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
   
    ?>
    <!--when update request is made--> 
    <form class="form-horizontal"  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table class="table table-responsive">
            <tr class="">
                <td><b>Category Name</b></td>
                <td></td>
                <td><input type="text" class="form-control" name="category" value="<?php echo $row[1];?>" ></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><p class="text-danger"><b>**Category Can't be updated**</b></p></td>
            </tr>
            <tr class="">
                <td><b>Sub-Category Name</b></td>
                <td></td>
                <td><input type="text" class="form-control" name="subcategory" value="<?php echo $row[2];?>"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="hidden" class="form-control" name="id" value="<?php echo $row[0];?>"></td>
                <td><p class="text-danger"><b>**In case of multiple sub-categories please insert them separating using comma(,)**</b></p></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" name="update" class="btn btn-success" value="update"></td>
            </tr>
        </table>            
    </form>
    <?php
}

}
$sql = "select * from types";
$result = mysqli_query($conn, $sql);
?>


<div class="container">
    <div class="col-sm-8 col-sm-offset-2">
        <h2 class="text-center">Categories</h2>
        <button class="btn btn-sm btn-info" id="new">Add New</button>
        <button class="btn btn-sm btn-danger" id="cancel">Cancel</button>
        <!--add new category form-->
        <form class="form-horizontal" id="add_new" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table class="table table-responsive">
                <tr class="">
                    <td><b>Category Name</b></td>
                    <td></td>
                    <td><input type="text" class="form-control" name="category"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><p class="text-danger"><b>**Make sure the category doesn't exist already**</b></p></td>
                </tr>
                <tr class="">
                    <td><b>Sub-Category Name</b></td>
                    <td></td>
                    <td><input type="text" class="form-control" name="subcategory"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><p class="text-danger"><b>**In case of multiple sub-categories please insert them separating using comma(,)**</b></p></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><input type="submit" name="submit" class="btn btn-success" value="Add"></td>
                </tr>

            </table>            
        </form>
        <table class="table table-responsive">
            <tr class="text-center">
                <td><b>sl</b></td>
                <td><b>Category</b></td>
                <td><b>Sub-Category</b></td>
                <td><b>Action</b></td>
            </tr>
            <?php
            $c = 0;
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo ++$c; ?></td>
                    <td><?php echo $row['category'] ?></td>
                    <td><?php echo $row['subcategory'] ?></td>
                    <td>
                        <a class="btn btn-warning" href="category.php?sl=<?php echo $row['sl'] ?>&action=update">Update</a>
                        <a class="btn btn-danger" href="category.php?sl=<?php echo $row['sl'] ?>&action=delete">DELETE</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

