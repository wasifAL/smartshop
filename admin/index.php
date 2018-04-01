<?php
//wiil start session if session is not started in the document
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}

if ($_SESSION['role'] === "admin") {
    if (!isset($_SESSION['link'])) {
        $_SESSION['link'] = 'base.php';
    }
    header("location:adminpanel.php");
} else if ($_SESSION['role'] === "customer") {
    header("location:../shop.php");
} else {
//db connection file called
    require '../db/dbcon.php';

//check if form is submitted
    if (isset($_POST['submit'])) {
        $id =  strtolower(trim($_POST['adminid']));        
        $pw = trim($_POST['Password']);
        $sql = "select * from admin where username='$id' and password='$pw'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) >0) {
            echo '<script>alert("successfully logged in")</script>';
            $_SESSION['user'] = $id;
            $_SESSION['role'] = "admin";
             header("location:adminpanel.php");
        } else {
            echo '<script>alert("your admin id & Password are incorrect'.$id .' '.$pw.'")</script>';
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
            <title>Admin Panel</title>
            <!-- Bootstrap Core CSS -->
            <link href="../css/bootstrap.min.css" rel="stylesheet">
            <!-- Custom CSS -->
            <link href="../css/admin.css" rel="stylesheet">
            <!-- Custom Fonts -->
            <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
            <style>
                #pos {
                    margin: 2% 30%;
                    position: fixed;
                }
            </style>
        </head>

        <body class="container-fluid">

            <div class="container" id="pos">
                <div class="col-sm-6 jumbotron">
                    <h2 class="text-center">Admin Login</h2>
                    
                    <form action="" method="post">                        
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control" id="username" type="text" name="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Username</label>
                            <input class="form-control" id="password" type="password" name="password">
                        </div>
                        <div class="form-group">
                            <input  class="btn btn-sm btn-success" type="submit" name="submit">
                        </div>
                        
                    </form>
                </div>
            </div>



            <!-- jQuery -->
            <script src="../js/jquery.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="../js/bootstrap.min.js"></script>

        </body>

    </html>

<?php } ?>
