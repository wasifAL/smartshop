
<div class="container">
    <?php if (isset($_SESSION['user'])) { ?>
        <!--chat widget-->
        <div class="chatarea">
            <div class="container-fluid">
                <div class="col-xs-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading" id="accordion">
                            <span class="glyphicon glyphicon-comment"></span> Chat &nbsp;&nbsp;<b class="notiChat"></b>
                            <div class="btn-group pull-right">
                                <a type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    <span class="glyphicon glyphicon-chevron-down"></span>
                                </a>
                            </div>
                        </div>

                        <div class="panel-collapse collapse" id="collapseOne">
                            <!--chat body-->
                            <div class="panel-body">
                                
                                <!--From user's id-->
                                <input type="hidden" value="<?PHP echo $_SESSION['user']; ?>" id="FromUser">

                                <!--chat texts view area-->
                                <ul class="chat" id="table1">  
                                    
                                </ul>

                            </div>


                            <div class="panel-footer">
                                <div class="input-group">
                                    <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                                    <span class="input-group-btn"><button class="btn btn-warning btn-sm" id="btn-chat">Send</button></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12 text-center">
                <p>Copyright &copy; <b>SmartShop</b> 2018</p>
            </div>
        </div>
    </footer>

</div>
<!-- /.container -->



</body>

</html>