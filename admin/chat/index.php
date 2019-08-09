<?php
if (!isset($_SESSION))
    session_start();
require 'header.php';
if ($_SESSION['role'] !== "admin" && $_SESSION['role'] !== "admission") {
    if (!empty($_SESSION['role'])) {
        if ($_SESSION['role'] === 'teacher')
            header("location:../../teacher/home.php");
        else if ($_SESSION['role'] === 'admin')
            header("location:../../student/home.php");
    }else {
        header("location:../../index.php");
    }
}
require '../../db/dbcon.php';
?>
<style>
    .notiChat{
        padding: 1px 5px 0px 5px;
        background-color: red;
        color: white;
        border-radius: 84px;
        font-size: 11px;                              
    }
    .col-sm-8{height: 100%;padding: 10px;}

    #table2 tr th,#table1 tr th{
        border-top:unset;
    }
    #table1{
        border:2px dotted #bbb;
    }
    #table1 tr{
        border-bottom:1px solid #fff6f6;
    }
    #table1 tr td p{
        padding: 0px 15px;
    }
</style>
<script>
    "use strict";
    $(document).ready(function () {
        var chatInterval = 250;
        var $to = $("#ToUser");
        var $from = $("#FromUser");
        var $chatInput = $("#chatInput");
        var $chatOutput = $("#table1");
        $("#table2").hide();
//        $(".notiChat").hide();

//send the message to the database along with sender id and receivers id
        function sendMessage() {
//            store receivers id
            var to = $to.val();
//            store senders id
            var from = $from.val();
//            store message
            var message = $chatInput.val();
//calling ajax for server request
            $.get("ajax.php", {
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
            var to = $to.val();
//            store senders id
            var from = $from.val();
//            ajax call for reading data
            $.get("ajax.php", {
                serial: 2,
                to: to,
                from: from
            }, function (data) {
//                pastes the data read from database 
                $chatOutput.html(data);
            });
        }
//        on message send button click
        $("#Send").click(function () {
//            store message
            var message = $chatInput.val();
//            check if the message is empty or not if empty show popup message
            if (message.trim().length == 0) {
                alert("Message Can't be empty");
            } else {
                sendMessage();
            }
        });
//        retrieves users who sent messages 
        function retrieveUser() {
            $.get("ajax.php", {
                serial: 3
            }, function (data) {
//                $("#userList").html(data);
            });
        }
        function setStatus() {
            //            store receivers id
            var to = $to.val();
            //            store senders id
            var from = $from.val();
            alert(to+" "+from);
            //            ajax call for reading data
            $.get("ajax.php", {
                serial: 4,
                to: to,
                from: from
            }, function (data) {
                $(".notiChat").hide();
            });
        }
        $("#chatInput").click(function () {
            setStatus();
        });

        setInterval(function () {
//            retrieveUser();

            if ($to.val().length != 0) {
                retrieveMessages();
            }
        }, chatInterval);


    });
//    Sets username for chat read and write
    function chat(var1, var2) {
//        sets var1 value to the element id ToUser
        document.getElementById("ToUser").value = var1;
        $("#table2").show();
        document.getElementById("nam1").innerHTML = var2 + " (" + var1 + ")";
    }

</script>
<div class="container">
    <h1 class="text-center" id="nam1"></h1>
    <aside class="col-sm-4">
        <p class="lead text-center">Users</p>
        <div class="list-group" id="userList">
            <?php
            $sql = "select distinct from_user from chat where to_user = 'admin'";
            if ($result = mysqli_query($conn, $sql)) {
                while ($row = mysqli_fetch_array($result)) {
                    $sql = "select count(*) from chat where (to_user='admin' and from_user='$row[0]') and status=0";
                    $res = mysqli_query($conn, $sql);
                    $r = mysqli_fetch_array($res);
                    $noti = 0;
                    if ($r[0] > 0)
                        $noti = $r[0];


                    $x = "select full_name from user where username='" . $row[0] . "'";
                    $y = mysqli_query($conn, $x);
                    $name = mysqli_fetch_array($y);
                    ?>
                    <a href="javascript:chat('<?php echo $row[0] ?>','<?php echo $name[0] ?>')" class="list-group-item"><?php echo ucfirst($name[0]); ?>  <b class="notiChat"><?php echo $noti; ?></b></a>

                    <?php
                }
            }
            ?>
        </div>
    </aside>

    <div class="col-sm-8">
        <div class="container-fluid">
            <input id="ToUser" type="hidden">
            <input id="FromUser" type="hidden" value="admin">
            <table class="table table-responsive table-condensed table-striped" id="table1">
                <tr id="chatOutput">
                    <th><h1>Welcome to Online Support</h1></th>
                </tr>                
            </table>

            <table class="table "  id="table2">
                <tr>
                    <th><input type="text" class="form-control form-group-lg" id="chatInput"></th>
                    <th>&nbsp;</th>
                    <th><a href="#" class="btn btn-default" id="Send" >Send</a></th>
                </tr>
            </table>
        </div>
    </div>
</div>
<script>
</script>

