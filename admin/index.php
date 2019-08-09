<?php
//wiil start session if session is not started in the document
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}

//check if there is any active session
if (isset($_SESSION['role'])) {
//    check the active user role
    if ($_SESSION['role'] === "admin")
        header("location:adminpanel.php");

    if ($_SESSION['role'] === "customer")
        header("location:../shop.php");
} else {

//db connection file called
    require '../db/dbcon.php';

// if the form is submitted
    if (isset($_POST['submit'])) {

        $id = strtolower(trim($_POST['username']));
        $pw = trim($_POST['password']);
        $sql = "select * from user where username='$id' and password='$pw' and role='admin'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $x= mysqli_fetch_assoc($result);
            echo '<script>alert("successfully logged in")</script>';
            $_SESSION['user'] = $id;
            $_SESSION['role'] = 'admin';
            $_SESSION['user_sl']=$x['sl'];
            header("location:adminpanel.php");
        } else {
            echo '<script>alert("your admin id & Password are incorrect' . $id . ' ' . $pw . '")</script>';
        }
    }
    ?>

    <!--login page--> 

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
                body{
                    width: 100%;
                    height: 100vh;
                    background-color:black;
                    background-image: url(../image/bg-admin.jpg);
                    background-position: center center;
                    background-repeat: no-repeat;
                    background-size: cover;
                }
                .l{
                    width: inherit;
                    height: inherit;                    
                    /*opacity: .5;*/
                }

                #pos {
                    margin-top: 5%;
                    margin-left: 30%;
                    position: fixed;
                    /*opacity: 1 !important;*/
                }
            </style>
        </head>


        <!--login form-->
        <body class="container-fluid">
            <div class="l">

            <div class="container" id="pos">
                <div class="col-sm-6 jumbotron">
                    <h2 class="text-center">Admin Login</h2>

                    <form method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">                        
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control" id="username" type="text" name="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
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
            </div>
        </body>

    </html>

<?php } ?>
