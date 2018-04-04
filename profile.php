
<?php
//including the header area
require 'header.php';
require 'db/dbcon.php';
//check and start sesssion if not started already
if (!isset($_SESSION))
    session_start();
if (isset($_SESSION['role'])) {
    $username = $_SESSION['user'];
    $role=$_SESSION['role'];
    $sql="select * from user where username=".$username." and role=".$role;
    if($conn->query($sql)){
        echo"<script>alert('all values received');</script>";
        $result=$conn->query($sql);
        if(mysqli_num_rows($result)>0)
        $row=$result->fetch_assoc();
        else
             echo"<script>alert('no value found');</script>";
    }
 else {
         echo"<script>alert('".$conn->error."');</script>";
    }
    ?>
    <div class="container col-sm-offset-2 col-sm-8 ">
        <form class="jumbotron form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2 class="text-center"> <?php echo $username." ".$role; ?> Profile</h2>
            <table class="table table-responsive">
                <!--full_name-->
                <tr class="form-group">
                    <td><b>Full Name</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input  name="full_name" value="<?php if ($status === 0) echo $full_name; ?>" placeholder="First Name" class="form-control"  type="text" readonly="true"> 
                    </td>
                </tr>
                <!--email-->
                <tr class="form-group">
                    <td><b>E-Mail</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input name="email" placeholder="E-Mail Address" value="<?php if ($status === 0) echo $email; ?>"  class="form-control"  type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="char@website.domain" readonly="true">                      
                    </td>
                </tr>
                <!--username-->
                <tr class="form-group">
                    <td><b>Username</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="username" placeholder="Username" value="<?php if ($status === 0) echo $username; ?>" class="form-control"  type="text"  pattern=".{6,15}" title="username must have 6 to 15 characters" readonly="true">                  
                    </td>
                </tr>
                <!--password-->
                <tr class="form-group">
                    <td><b>Password</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                        <input name="password" placeholder="Password" class="form-control"  type="password"  pattern=".{6,20}" title="password must be 6 to 20 characters" readonly="true">                
                    </td>
                </tr>
                <!--gender-->
                <tr class="form-group">
                    <td><b>Gender</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-baby-formula"></i></span>
                        <select class="form-control" name="gender" readonly="true">
                            <option value="Undefined">Undefined</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>              
                    </td>
                </tr>
                <!--phone-->
                <tr class="form-group">
                    <td><b>Phone No #</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input name="phone" placeholder="8801700000000" value="<?php if ($status === 0) echo $phone; ?>"  class="form-control" type="tel" readonly="true">
                    </td>
                </tr>
                <!--address-->
                <tr class="form-group">
                    <td><b>Shipping Address</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input name="address" placeholder="Shipping Address"  value="<?php if ($status === 0) echo $address; ?>" class="form-control" type="text" readonly="true">
                    </td>
                </tr>
                <!--zip_code-->
                <tr class="form-group">
                    <td><b>Zip Code</b></td>
                    <td class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input name="zip_code" placeholder="Zip Code" value="<?php if ($status === 0) echo $zip_code; ?>"  class="form-control"  type="text" readonly="true">
                    </td>
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


<?php } else header("location:login.php"); ?>
