<?php
//wiil start session if session is not started in the document
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}
//check if there is any active session and role is admin
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] !== "admin")
        header("location:../shop.php");
}
require '../db/dbcon.php';
require 'header.php';


$full_name = $email = $username = $password = $gender = $phone = $address = $zip_code = $message = '';
$status = 1;

function test1($val) {
    $data = trim($val);
    $data = stripslashes($val);
    $data = htmlspecialchars($val);
    return $val;
}

if (isset($_POST['update_profile'])) {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $phone = test1($_POST['contact_no']);
    $address = $_POST['address'];
    $zip_code = $_POST['zip_code'];
    $full_name = test1($full_name);
    $query = "UPDATE `user` SET ";
    $message = "";
// check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/", $full_name)) {
        $message = $message . " Only letters and white space allowed";
        $status = 0;
    } else {
        $query = $query . "`full_name`='$full_name'";
    }
    if (!empty($gender)) {
        if (strtolower($gender) === "female" || strtolower($gender) === "male")
            $query = $query . ",`gender`='" . ucfirst($gender) . "'";
        else {
            $message = $message . " <br>Gender value is not correct only Male and Female is allowed";
            $status = 0;
        }
    } else {
        $message = $message . " <br>Gender value can not be empty and only Male and Female is allowed";
        $status = 0;
    }
    if (!empty($phone)) {
        $query = $query . ",`contact_no`='$phone' ";
    } else {
        $message = $message . " <br>Phone No can not be empty ";
        $status = 0;
    }
    if (!empty($address)) {
        $query = $query . ",`address`='$address' ";
    } else {
        $status = 0;
        $message = $message . " <br>Address can not be empty ";
    }
    if (!empty($zip_code)) {
        $query = $query . ",`zip_code`='$zip_code' ";
    }

    if (isset($_FILES['pp']['name'])) {
//        drop previous profile picture
        $s = "select `profile_picture` from user where sl=" . $_SESSION['user_sl'];
        $j = mysqli_query($conn, $s);
        $user_pic = mysqli_fetch_array($j);
        if (!is_null($user_pic[0])) {
            unlink("../".$user_pic[0]);
        }

        // directory where image will be stored
        $target_dir = "pp/" . $_SESSION['user'];
        $ext = explode('.', basename($_FILES["pp"]["name"]));
        $target_file = $target_dir . "." . end($ext);
        // echo $target_file;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $message = $message . "<br>Sorry, only JPG, JPEG, PNG files are allowed.";
            $status = 0;
        } else {
            if (move_uploaded_file($_FILES["pp"]["tmp_name"], "../".$target_file)) {
                $query = $query . ",`profile_picture`='$target_file'";
            } else {
                echo"<script>alert('image not inserted');</script>";
            }
        }
    }

    $query = $query . " where `sl` = " . $_SESSION['user_sl'];
    if ($status !== 0) {
        if (mysqli_query($conn, $query)) {
            echo"<script>alert('Profile Updated');</script>";
        } else
            echo"<script>alert('Profile Not Updated');</script>";
    }
    else {
        echo"<script>alert('" . $message . "');</script>";
    }
}

if (isset($_GET['sl'])) {
    $sql = "select * from user where sl='" . $_GET['sl'] . "'";
} else {
    $sql = "select * from user where username='" . $_SESSION['user'] . "'  and role='" . $_SESSION['role'] . "'";
}
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<script>
    $(document).ready(function () {
        $(".form-control").attr("disabled", "true");
        $("#cancel").hide();
        $(".hid").hide();

        $("#edit").click(function () {
            $(this).hide();
            $("#cancel").show();
            $(".enable").removeAttr("disabled");
            $(".hid").show();
        });
        $("#cancel").click(function () {
            $(this).hide();
            $("#edit").show();
            $(".enable").attr("disabled", "true");
            $(".hid").hide();
        });
    });
</script>

<div class="container">
    <h1 class="text-center text-info">Welcome to <?php echo $_SESSION['user']; ?>'s Profile</h1><br>
    <div class="col-sm-offset-1 col-sm-7">
        <form method="POST" class="form-horizontal" enctype="multipart/form-data">
            <table class="table table-responsive">
                <tr class="form-group">
                    <td><b>Full Name</b></td>
                    <td><input class="form-control enable" type="text" name="full_name" value="<?php echo $row['full_name']; ?>"></td>
                </tr>
                <tr class="form-group">
                    <td><b>Email Address</b></td>
                    <td><input class="form-control" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="char@website.domain" name="email" value="<?php echo $row['email']; ?>"></td>
                </tr>
                <tr class="form-group">
                    <td><b>Username</b></td>
                    <td><input class="form-control" type="text" name="username" value="<?php echo $row['username']; ?>"></td>
                </tr>
                <tr class="form-group">
                    <td><b>Role</b></td>
                    <td><input class="form-control " type="text" name="role" value="<?php echo $row['role']; ?>"></td>
                </tr>
                <tr class="form-group">
                    <td><b>Gender</b></td>
                    <td><input class="form-control enable" type="text" name="gender" value="<?php echo $row['gender']; ?>"></td>
                </tr>
                <tr class="form-group">
                    <td><b>Contact Number</b></td>
                    <td><input class="form-control enable" type="text" name="contact_no" pattern="[0-9]{13}" title="Must have 13 digit including country code 880" value="<?php echo $row['contact_no']; ?>"></td>
                </tr>
                <tr class="form-group">
                    <td><b>Address</b></td>
                    <td><input class="form-control enable" type="text"  pattern=".{4,}" name="address" value="<?php echo $row['address']; ?>"></td>
                </tr>
                <tr class="form-group">
                    <td><b>Zip Code</b></td>
                    <td><input class="form-control enable" type="tel" name="zip_code" value="<?php echo $row['zip_code']; ?>"></td>
                </tr>
                <tr class="form-group hid">
                    <td><b>Change Profile Picture</b></td>
                    <td><input class="form-control enable" type="file" name="pp"></td>
                </tr>
                <tr class="form-group hid">
                    <td></td>
                    <td><input class="btn btn-warning" type="submit" name="update_profile" value="Update Profile"></td>
                </tr>

            </table>
        </form>
    </div>
    <div class="col-sm-3">
        <?php if ($row['profile_picture'] === NULL) { ?>
            <img  src="../pp/pp.jpg" class="img-responsive img-thumbnail"><br><br>
        <?php } else { ?>
            <img src="../<?php echo $row['profile_picture']; ?>" height="300" width="300"> <br><br>
        <?php } ?>
        <button id="edit" class="btn btn-block btn-lg btn-info">Edit Profile</button>
        <button id="cancel" class="btn btn-block btn-lg btn-danger">Cancel</button>
    </div>
</div>

<?php
require 'footer.php';
?>
