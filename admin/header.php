<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Admin Panel</title>
        <!-- Bootstrap Core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="admin.css" type="text/css"/>

        <!-- jQuery -->
        <script src="../js/jquery.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <style>
            .navbar {
                border-radius: unset;
            }
            .btn{
                border-radius: 0px;
            }
            .notiChat{
                padding: 1px 5px 0px 5px;
                background-color: red;
                color: white;
                border-radius: 84px;
                font-size: 11px;
            }
            .noti{
                padding: 1px 5px 0px 5px;
                background-color: red;
                color: white;
                border-radius: 84px;
                font-size: 11px;
            }

        </style>
        <script type="text/javascript">
            "use strict";
            $(document).ready(function () {
                $(".notiChat").hide();
                $(".noti").hide();
                function messageStatus() {
                    //            ajax call for reading data
                    $.get("messageCheck.php", {
                        serial: 1
                    }, function (data) {
//                      changes the data type of the success result
                        var id = parseInt(data);
                        if (id > 0) {
                            $(".notiChat").show();
                            $(".notiChat").html(data);
                        } else {
                            $(".notiChat").hide();
                        }
                    });
                }
                function notiStatus() {
                    //            ajax call for reading data
                    $.get("messageCheck.php", {
                        serial: 2
                    }, function (data) {
//                        alert(data);
//                      changes the data type of the success result
                        var id = parseInt(data);
                        if (id > 0) {
                            $(".noti").show();
                            $(".noti").html(data);
                        } else {
                            $(".noti").hide();
                        }
                    });
                }
                setInterval(function () {
                    messageStatus();
                    notiStatus();
                }, 600);
            });
        </script>

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="adminpanel.php">SmartShop</a>
                    </div>



                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="../index.php"><i class="fa fa-fw fa-shopping-cart"></i> Shop</a>
                        </li>
                        <!--products menu-->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-th-list"></i> Products <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="new_product.php"><i class="fa fa-fw fa-plus-circle"></i> Add New Product</a>
                                </li>
                                <li>
                                    <a href="view_product.php"><i class="fa fa-fw fa-list-alt"></i> View Products</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="category.php"><i class="fa fa-fw fa-list-alt"></i> Categories</a>
                        </li>
                        <li>
                            <a href="offer.php"><i class="fa fa-fw fa-list-alt"></i> Offers</a>
                        </li>
                        <li>
                            <a href="orders.php"><i class="fa fa-fw fa-list-alt"></i> Order List</a>
                        </li>

                        <li>
                            <a href="chat/"><i class="fa fa-fw fa-envelope"></i> Inbox&nbsp;<b class="notiChat"></b></a>
                        </li>
                        <li>
                            <a href="notification.php"><i class="fa fa-fw fa-bell"></i> Notification&nbsp;<b class="noti"></b></a>
                        </li>
                        <!--customers menu-->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-group"></i> Customer <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="registration.php"><i class="fa fa-fw fa-user-md"></i> Add User</a>
                                </li>
                                <li>
                                    <a href="customer_list.php"><i class="fa fa-fw fa-users"></i> View Customer List</a>
                                </li>

                            </ul>
                        </li>
                        <!--If logged in then this user details menu will appear -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['user']; ?>
                                <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="../logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- /.navbar-collapse -->
            </nav>
