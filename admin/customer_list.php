<?php
if (!isset($_SESSION))
    session_start();
if ($_SESSION['role'] !== 'admin' || !isset($_SESSION['role']))
    header('location:index.php');
else {
    require 'header.php';
    require '../db/dbcon.php';
    ?>

    <script type="text/javascript">
        function update(cod, act) {
            document.getElementById("email").value = ".email" + cod;
            document.getElementById("action").value = act;
            document.getElementById("serial").value = cod;
        }

        $(document).ready(function () {
            function validateEmail(emailField) {
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (reg.test(emailField) == false)
                {
                    return false;
                }
                return true;

            }
            $(".btn-warning").hide();
            $(".hid").attr("readonly", "true");

            $(".update").click(function () {
                $(".btn-warning").hide();
                $(".btn-info").show();
                $(".hid").attr("readonly", "true");
                setTimeout(function () {
                    $action = document.getElementById("action").value;
                    $user_sl = document.getElementById("serial").value;
                    $email = document.getElementById("email").value;
                    $("." + $action + $user_sl).show();
                    $edit_btn = ".up" + $user_sl;
                    $($edit_btn).hide();
                    $($email).removeAttr("readonly");

                    $("." + $action + $user_sl).click(function () {
                        var email = $($email).val();
                        var x = validateEmail(email);
                        if (x === true) {
                            $.get("customer_action.php", {
                                kaj: 'update',
                                sl: $user_sl,
                                email: email
                            }, function (data) {
                                //                            when product is success fully updated
                                alert("Email Updated");
                                window.location.replace(data);
                            });
                        } else {
                            alert("email not valid");
                        }
                    });
                }, 100);               
               
            });
             $(".delete").click(function () {
                    setTimeout(function () {
                        $user_sl = document.getElementById("serial").value;
                         $.get("customer_action.php", {
                                kaj: 'delete',
                                sl: $user_sl
                            }, function (data) {
                                //                            removed user
                                alert("User Removed from the system");
                                window.location.replace(data);
                            });
                    }, 100);
                });
        });


    </script>

    <div class="container">

        <input type="text" id="email">
        <input type="text" id="serial">
        <input type="text" id="action">
        <table class="table table-responsive table-condensed">
            <!--table header-->
            <tr>
                <th>No.</th>
                <th>Picture</th>
                <th>Username</th>
                <th>Password</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Gender</th>            
                <th>Phone</th>            
                <th>Shipment Address</th>            
                <th>Actions</th>            
            </tr>

            <!--table content-->
            <?php
            $sql = "select * from user";
            $res = mysqli_query($conn, $sql);
            $c = 0;
            while ($user = mysqli_fetch_assoc($res)) {
                ?>
                <tr>
                    <td><?php echo ++$c; ?> </td>
                    <td>
                        <?php
                        $img = "";
                        if (is_null($user['profile_picture']))
                            $img = "../pp/pp.jpg";
                        else
                            $img = "../" . $user['profile_picture'];
                        ?>
                        <img class="" src="<?php echo $img; ?>" width="50" height="50">
                    </td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['password']; ?></td>
                    <td><?php echo ucfirst($user['full_name']); ?></td>
                    <td> <input class="form-control hid  <?php echo "email" . $user['sl']; ?> " value="<?php echo $user['email']; ?>"> </td>
                    <td><?php echo ucfirst($user['gender']); ?></td>            
                    <td><?php echo $user['contact_no']; ?></td>            
                    <td><?php echo $user['address']; ?></td>            
                    <td>
                        <?php if ($user['role'] !== "admin") { ?>
                            <a class="btn btn-danger delete" href="javascript:update('<?php echo $user['sl']; ?>','delete')">Delete</a>
                        <?php } ?>
                        <a class="btn btn-info update up<?php echo $user['sl']; ?>" href="javascript:update('<?php echo $user['sl']; ?>','update')" >Edit</a>

                        <a class="btn btn-warning update<?php echo $user['sl']; ?>" href="#">Update</a>
                        <a class="btn btn-default" href="orders.php?user=<?php echo $user['sl']; ?>">Orders</a>
                    </td>            
                </tr>
            <?php } ?>

        </table>
    </div>



    <?php
    require 'footer.php';
}
?>