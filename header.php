<?php
if (!isset($_SESSION))
    session_start();
require 'db/dbcon.php';

//check values
function test($val) {
    $data = trim($val);
    $data = stripslashes($val);
    $data = htmlspecialchars($val);
    return $val;
}

if (isset($_POST['user_login'])) {
    require 'db/dbcon.php';
    $id = strtolower(trim($_POST['username']));
    $pw = trim($_POST['password']);
    $sql = "select * from user where username='$id' and password='$pw' and role='customer'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $x = mysqli_fetch_assoc($result);
        echo '<script>alert("successfully logged in")</script>';
        $_SESSION['user'] = $id;
        $_SESSION['role'] = 'customer';
        $_SESSION['user_sl'] = $x['sl'];
    } else {
        echo '<script>alert("your admin id & password are incorrect' . $id . ' ' . $pw . '")</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Online Smart Shop</title>

        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/chat.css"/>
        <link href="css/style.css" rel="stylesheet"> 

        <!-- jQuery -->
        <script src="js/jquery.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <style>
            .noti{
                padding: 1px 5px 0px 5px;
                background-color: red;
                color: white;
                border-radius: 84px;
                font-size: 11px;
                position: absolute;
                top: 4px;
            }
            .notiChat{
                padding: 1px 5px 0px 5px;
                background-color: red;
                color: white;
                border-radius: 84px;
                font-size: 11px;                              
            }
        </style>
        <!--scripts for live chat-->
        <script>
            "use strict";
            $(document).ready(function () {
                var chatInterval = 250;
                var $to = "admin";
                var $from = $("#FromUser").val();
                var $chatInput = $("#btn-input");
                var $chatOutput = $("#table1");

                //send the message to the database along with sender id and receivers id
                function sendMessage() {
                    //            store receivers id
                    var to = $to;
                    //            store senders id
                    var from = $from;
                    //            store message
                    var message = $chatInput.val();
                    //calling ajax for server request
                    $.get("chatAjax.php", {
                        serial: 1,
                        to: to,
                        from: from,
                        text: message
                    }, function (data) {
                        $chatOutput.html(data);
                        $chatInput.val("");
                    });
                    retrieveMessages();
                }
                //read messages from the database 
                function retrieveMessages() {
                    //            store receivers id
                    var to = $to;
                    //            store senders id
                    var from = $from;
                    //            ajax call for reading data
                    $.get("chatAjax.php", {
                        serial: 2,
                        to: to,
                        from: from
                    }, function (data) {
                        //                pastes the data read from database 
                        $chatOutput.html(data);
                    });
                }

                //        new message notification
                function messageStatus() {
                    //            store receivers id
                    var to = $to;
                    //            store senders id
                    var from = $from;
                    //            ajax call for reading data
                    $.get("chatAjax.php", {
                        serial: 3,
                        to: to,
                        from: from
                    }, function (data) {
//                      changes the data type of the success result
                        var id = parseInt(data);
                        if (id > 0) {
                            $(".notiChat").show();
                            $(".notiChat").html(data);
                        }else{
                             $(".notiChat").hide();
                        }

                    });
                }
                //        new message notification
                function setStatus() {
                    //            store receivers id
                    var to = $to;
                    //            store senders id
                    var from = $from;
                    //            ajax call for reading data
                    $.get("chatAjax.php", {
                        serial: 4,
                        to: to,
                        from: from
                    }, function (data) {
                        $(".notiChat").hide();
                    });
                }
                $("#btn-input").click(function () {
                    setStatus();
                });
                //        message send button click actions
                $("#btn-chat").click(function () {
                    //            store message
                    var message = $chatInput.val();
                    //            check if the message is empty or not if empty show popup message
                    if (message.trim().length == 0) {
                        alert("Message Can't be empty");
                    } else {
                        sendMessage();
                    }
                });
                //calls the retrieveMessages funtion after every 250 miliseconds for refreshing the message box
                setInterval(function () {
                    if ($to.length != 0) {
                        retrieveMessages();
                        messageStatus();
                    }
                }, chatInterval);


            });

        </script>

    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-home"></span> SmartShop</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="shop.php"><span class="glyphicon glyphicon-inbox"></span> Shop</a></li>
                        <li><a href="search.php"><i class="fa fa-search" aria-hidden="true"></i> Search</a></li>
                        <?php
                        $c = 0;
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                                $c++;
                            }
                        }
                        ?>
                        <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart
                                <?php if ($c > 0) { ?>
                                    <b class="noti"><?php echo $c; ?></b>
                                <?php } ?>
                            </a></li>

                        <?php if (!isset($_SESSION['role'])) { ?>
                            <li><a href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>                            
                            <?php
                        } else {

                            $q1 = "SELECT * FROM `notification` WHERE `for_user`=" . $_SESSION['user_sl'] . " and `status`=0";
                            $rx = mysqli_query($conn, $q1);
                            $n = mysqli_num_rows($rx);
                            ?>
                            <li >
                                <a href="notification.php"><i class="glyphicon glyphicon-bell"></i>
                                    <?php if ($n > 0) { ?>
                                        <b class="noti"><?php echo $n; ?></b>
                                    <?php } ?>
                                </a>

                            </li>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span>
                                    <?php // echo $n; ?></a>
                                <ul class="dropdown-menu">
                                    <li><a href="profile.php">My Profile</a></li>
                                    <?php if ($_SESSION['role'] === 'admin') { ?>
                                        <li><a href="admin/adminpanel.php">Admin Panel</a></li>
                                    <?php } ?>
                                    <li><a href="orders.php"><span class="glyphicon glyphicon-list"></span> My Orders</a></li>
                                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>


        <!-- Login Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">User Login</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">     
                            <div class="">
                                <label for="username">Username</label>
                                <input class="form-control" id="username" type="text" name="username">
                            </div>
                            <div class="">
                                <label for="password">Password</label>
                                <input class="form-control" id="password" type="password" name="password">
                            </div>
                            <input  class="btn btn-sm btn-success" id="submit-login" style="display: none" type="submit" name="user_login">
                        </form>

                    </div>
                    <div class="modal-footer">
                        <a href="registration.php" class="btn btn-default">Sign Up</a>
                        <label class="btn btn-success" for="submit-login" tabindex="0">Log In</label>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>