<?php

require '../db/dbcon.php';

if ($_POST['serial'] === '1') {
    $id = $_POST['sl'];
    echo $id;


    $sql = "select * from types where sl=" . $id;
    if ($result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_array($result);

       // $sql = "select count(category) from products where category='" . $row[1] . "'";
        //$res = mysqli_query($conn, $sql);
        //$r = mysqli_fetch_array($res);
        //if (intval($r) < 3) {
            $subcategories = explode(",", $row[2]);
            echo"<option value=''>Select Subcategory</option>";
            foreach ($subcategories as $val) {
                echo"<option value='" . $val . "'>" . $val . "</option>";
           }
        //} else
          //  echo"<option class='text-danger' value=''>Can't add more products in selected Category</option>";
    }else {

        echo mysqli_error($conn);
    }
}