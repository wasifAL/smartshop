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
    echo '<p><h3>Checkout</h3></p>';

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

            $result = $conn->query("SELECT product_code,offers,product_name, product_brand, product_description, stock, price FROM products WHERE sl = '" . $product_id . "'");

            if ($result) {

                while ($obj = $result->fetch_object()) {
                    if ($obj->offers === '') {
                        $cost = $obj->price * $quantity; //work out the line cost
                        $total = $total + $cost; //add to the total cost
                    } else {
                        $cost = $obj->price * $quantity; //work out the line cost
                        $cost = $cost - ($cost * (floatval($obj->offers) / 100));
                        $total = $total + $cost;
                    }

                    echo '<tr>';
                    echo '<td>' . $obj->product_code . '</td>';
                    echo '<td>' . $obj->product_name . '</td>';
                    echo '<td>' . $obj->product_brand . '</td>';
                    echo '<td>' . $quantity . '&nbsp;</td>';
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
        echo '<td colspan="5" align="right"><a href="cart.php" class="btn btn-success">Go To Cart</a>';
        
        if (isset($_SESSION['user'])) {
            
        } else {
            echo '<a class="btn btn-info" href="login.php">Login</a>';
        }

        echo '</td>';

        echo '</tr>';
        echo '</table>';
    } else {
        echo "You have no items in your shopping cart.";
    }
    ?>
</div>




<div class="container">
    <form action='https://sandbox.2checkout.com/checkout/purchase' method='post'>
        <input type='hidden' name='sid' value='901375872' />
        <input type='hidden' name='mode' value='2CO' />
        <?php
        if (isset($_SESSION['cart'])) {
            $i = 0;
            foreach ($_SESSION['cart'] as $product_id => $quantity) {

                $result = $conn->query("SELECT product_code,product_name, product_brand, product_description, stock, price,offers FROM products WHERE sl = " . $product_id);
                if ($result) {

                    while ($obj = $result->fetch_object()) {
                        $i++;
                        if ($obj->offers !== '') {
                            $current = floatval($obj->price) - (floatval($obj->price) * (floatval($obj->offers) / 100));
                        } else
                            $current = $obj->price;
                        ?>

                        <input type='hidden' name='li_<?php echo $i; ?>_type' value='<?php echo $obj->product_name ?>' >
                        <input type='hidden' name='li_<?php echo $i; ?>_name' value='<?php echo $obj->product_brand ?>' >
                        <input type='hidden' name='li_<?php echo $i; ?>_product_id' value='<?php echo $obj->product_code ?>' >
                        <input type='hidden' name='li_<?php echo $i; ?>__description' value='<?php echo $obj->product_description ?>' >
                        <input type='hidden' name='li_<?php echo $i; ?>_price' value='<?php echo $current; ?>' >
                        <input type='hidden' name='li_<?php echo $i; ?>_quantity' value='<?php echo $quantity ?>' >
                        <input type='hidden' name='li_<?php echo $i; ?>_tangible' value='N' >
                        <?php
                    }
                }
            }
        }
        ?>


        <?php
        $id = $_SESSION['user'];
        $result = $conn->query('SELECT * FROM user WHERE username ="' . $id . '"');
        if ($result) {

            while ($obj = $result->fetch_object()) {
                ?>
                <input type='hidden' name='card_holder_name' value='<?php echo $obj->full_name; ?>' required="" placeholder="Card Holder Full Name" />
                <input type='hidden' name='street_address' value='<?php echo $obj->address ?>' />
                <input type='hidden' name='street_address2' value='' />
                <input type='hidden' name='city' value='' />
                <input type='hidden' name='state' value='' />
                <input type='hidden' name='zip' value='123' />
                <input type='hidden' name='country' value='BD' />
                <input type='hidden' name='email' value='<?php echo $obj->email ?>' />
                <input type='hidden' name='phone' value='<?php echo $obj->contact_no ?>' />
                <?php
            }
        }
        ?>
        <input class="btn btn-success" name='submit' type='submit' value='Payment Proceed' />
    </form>
    <?php
    if (isset($_POST['submit'])) {
        header('Location: orders-update.php');
    }
    ?>
</div>

<?php require 'footer.php'; ?>
       