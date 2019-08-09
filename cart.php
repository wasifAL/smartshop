<?php
//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}
include 'db/dbcon.php';
require 'header.php';
?>



    <div class="container">
        <?php
        echo '<p><h3>Your Shopping Cart</h3></p>';
        if (isset($_SESSION['cart'])) {
            $total = 0;
            echo '<table class="table table-responsive">';
            echo '<tr>';
            echo '<th>Code</th>';
            echo '<th>Name</th>';
            echo '<th>Brand</th>';
            echo '<th>Quantity</th>';
            echo '<th>Cost</th>';
            echo '</tr>';
            foreach ($_SESSION['cart'] as $product_id => $quantity) {

                $result = $conn->query("SELECT product_code, product_name, product_brand, product_description, price, stock,offers FROM products WHERE sl = '" . $product_id . "'");

                if ($result) {
                    while ($row = $result->fetch_object()) {
                        if($row->offers ===''){
                        $cost = $row->price * $quantity; //work out the line cost
                        $total = $total + $cost; //add to the total cost
                        }else{
                            $cost = $row->price * $quantity; //work out the line cost
                            $cost = $cost-($cost*(floatval($row->offers)/100));
                             $total = $total + $cost;
                        }
                        echo '<tr>';
                         echo '<td>' . $row->product_code . '</td>';
                        echo '<td>' . $row->product_name . '</td>';
                        echo '<td>' . $row->product_brand . '</td>';
                        echo '<td>' . $quantity . '&nbsp;<a class="btn btn-success" style="padding:5px;" href="update-cart.php?action=add&id=' . $product_id . '">+</a>&nbsp;<a class="btn btn-danger" style="padding:5px;" href="update-cart.php?action=remove&id=' . $product_id . '">-</a></td>';
                        echo '<td>' . $cost . '</td>';
                        echo '</tr>';
                    }
                }
            }

            echo '<tr>';
            echo '<td colspan="4" align="right">Total</td>';
            echo '<td>' . $total . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td colspan="5" align="right"><a href="update-cart.php?action=empty" class="btn btn-warning">Empty Cart</a>&nbsp;'
            . '<a href="shop.php" class="btn btn-success ">Continue Shopping</a>&nbsp;';
            if (isset($_SESSION['user'])) {
                echo '<a class="btn btn-primary" href="checkout.php">Checkout</a>';
            } else {
                echo '<a href="#" class="btn btn-info" data-toggle="modal" data-target="#myModal">Login</a>';
            }

            echo '</td>';
            echo '</tr>';
            echo '</table>';
        } else {
            echo "You have no items in your shopping cart.";
        }
        ?>
    </div>







<div class="navbar-fixed-bottom">
        <?php
        require 'footer.php';
        ?>
    </div>
