<?php
//including the header area

require '../db/dbcon.php';

//check and start sesssion if not started already
if (!isset($_SESSION))
    session_start();

$status = 1;
$mfullname = $memail = $musername = $mpassword = $mphone = $maddress = "*";
$full_name = $email = $username = $password = $gender = $phone = $address = $zip_code = '';

function test1($val) {
    $data = trim($val);
    $data = stripslashes($val);
    $data = htmlspecialchars($val);
    return $val;
}

if (isset($_SESSION['role'])&&$_SESSION['role']==="admin") {

    if (isset($_POST['submit'])) {

        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $zip_code = $_POST['zip_code'];
        $role = 'customer';

        $full_name = test1($full_name);

        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $full_name)) {
            $mfullname = $mfullname . " Only letters and white space allowed";
            $status = 0;
        }

        $email = test1($email);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $status = 0;
        }
//        insert into database and complete registration
        if ($status === 1) {
            $sql = "INSERT INTO `user`(`username`, `password`, `full_name`, `email`, `role`, `contact_no`, `address`, `gender`, `zip_code`) VALUES ('$username','$password','$full_name','$email','$role','$phone','$address','$gender','$zip_code')";
            if ($conn->query($sql)) {
                echo "<script>alert('User Registration Successfull');</script>";
                header("location:customer_list.php");
            } else
                echo "<script>alert('" . $conn->error . "');</script>";
        }
    }
    require 'header.php';
    ?>
    <style>
        .message{color:red; }
    </style>
    <script>
        $(document).ready(function () {

        });
    </script>

    <div class="container col-sm-offset-2 col-sm-8 ">
        <form class="jumbotron form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2 class="text-center"> User Registration Form</h2>
            <table class="table table-responsive">
                <!--full_name-->
                <tr class="form-group">
                    <td><b>Full Name</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input  name="full_name" value="<?php if ($status === 0) echo $full_name; ?>" placeholder="Full Name" class="form-control"  type="text" required> 
                    </td>
                    <td class="message"><?php echo $mfullname; ?></td>
                </tr>
                <!--email-->
                <tr class="form-group">
                    <td><b>E-Mail</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input name="email" placeholder="E-Mail Address" value="<?php if ($status === 0) echo $email; ?>"  class="form-control"  type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="char@website.domain" required>                      
                    </td>
                    <td class="message"><?php echo $memail; ?></td>
                </tr>
                <!--username-->
                <tr class="form-group">
                    <td><b>Username</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="username" placeholder="Username" value="<?php if ($status === 0) echo $username; ?>" class="form-control"  type="text"  pattern=".{6,15}" title="username must have 6 to 15 characters" required>                  
                    </td>
                    <td class="message"><?php echo $musername; ?></td>
                </tr>
                <!--password-->
                <tr class="form-group">
                    <td><b>Password</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                        <input name="password" placeholder="Password" class="form-control"  type="password"  pattern=".{6,20}" title="password must be 6 to 20 characters" required>                
                    </td>
                    <td class="message"><?php echo $musername; ?></td>
                </tr>
                <!--gender-->
                <tr class="form-group">
                    <td><b>Gender</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-baby-formula"></i></span>
                        <select class="form-control" name="gender" required>
                            <option value="Undefined">Undefined</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>              
                    </td>
                    <td class="message"><?php echo $musername; ?></td>
                </tr>
                <!--phone-->
                <tr class="form-group">
                    <td><b>Phone No #</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input name="phone" placeholder="8801700000000" value="<?php if ($status === 0) echo $phone;  ?>"  class="form-control"
                               type="tel" pattern="{13}" title="Must have 13 digit including country code 880" required>
                    </td>
                    <td class="message"><?php echo $mphone; ?></td>
                </tr>
                <!--address-->
                <tr class="form-group">
                    <td><b>Shipping Address</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input name="address" placeholder="Shipping Address"  value="<?php if ($status === 0) echo $address; ?>"
                               class="form-control" type="text" required>
                    </td>
                    <td class="message"><?php echo $maddress; ?></td>
                </tr>
                <!--zip_code-->
                <tr class="form-group">
                    <td><b>Zip Code</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input name="zip_code" placeholder="Zip Code" value="<?php if ($status === 0) echo $zip_code; ?>"  class="form-control"  type="text">
                    </td>
                    <td class="message"></td>
                </tr>
            </table> 
            <!-- Submit the form -->
            <div class="form-group">
                <label class="col-md-4 control-label"></label>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-warning"  name="submit">Send <span class="glyphicon glyphicon-send"></span></button>
                </div>
            </div>
        </form>

    </div>
    <?php
    require 'footer.php';
} else {
    if ($_SESSION['role'] === 'admin')
        header('location:admin/adminpanel.php');
    else
        header('location:shop.php');
}
?>