<?php
//wiil start session if session is not started in the document
if (session_id() == '' ||!isset($_SESSION)) {
session_start();
}
if ($_SESSION['role'] === "admin") {
if (!isset($_SESSION['link'])) {
$_SESSION['link'] = 'base.php';
} else if (isset($_GET['link'])) {
$_SESSION['link'] = $_GET['link'];
}
require 'header.php';
?>

<div id="page-wrapper">

    <div class="container-fluid">
            <div class="row" id="panelarea">
                <?php require $_SESSION['link']; ?>
            </div>
        <script type="text/javascript">
            $(document).ready(function () {

            });
            function mylink(link) {
                $(document).ready(function () {
                    $("#panelarea").load(link);
                });
            }
        </script>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php
require 'footer.php';}
else    header("location:../index.php");
?>

