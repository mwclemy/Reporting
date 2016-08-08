<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php include("includes/functions.php"); ?>
<?php $userid = get_userid(); ?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Report System</title>

        <!-- Bootstrap Core CSS -->
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="main.php">Report System</a>    
                </div>
             <ul class="nav navbar-top-links navbar-right">
                  <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="myprofile.php"><i class="fa fa-user fa-fw"></i> My Profile</a>
                            </li>
                            <li><a href="change_credentials.php"><i class="fa fa-gear fa-fw"></i> Change Credentials</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                      
                    </li>
                   </ul>
               <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">

                            <li>
                                <a href="main.php" > HOME</a>
                            </li>
                            <?php echo navigation($userid) ?>

                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->



            <div id="page-wrapper">



                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"> Downgrade Connection </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">


                                        <form role="form" id="loginForm" method="POST" action="request_processing.php?request_type=Downgrade">

                                            <div class="form-group">
                                                <label>Customer Code No </label>
                                                <input id="ccode" class="form-control"  name="ccode" placeholder="Enter valid customer  code no">
                                                <div id="cc"> </div>
                                            </div >
                                            <div id="upgrade" style="display:none;">
                                                <div class="form-group">
                                                    <label>New Package</label>
                                                    <input id="npack" class="form-control" name="npack" placeholder="Enter Customer New Package">
                                                    <div id="np"> </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="comment">Comment:</label>
                                                    <textarea class="form-control"  rows="4" id="comm" name="comm"></textarea>
                                                </div>



                                                <button type="submit" class="btn btn-default" name="submit" value="submit">Submit Button</button>
                                                <button type="reset" class="btn btn-default">Reset Button</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->

                                    <!-- /.col-lg-6 (nested) -->
                                </div>
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->


            </div>





            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="dist/js/sb-admin-2.js"></script>

        <script src="dist/js/form_validation.js"></script>
         <script type="text/javascript">
            var userid = "<?php echo $userid; ?>";
            $(document).ready(function () {
                updateAlerts();
                window.setInterval(function () {
                    updateAlerts();
                }, 10000);

                $("#mark").click(function (e) {
                    $('#mes').hide();
                });
            });


            function updateAlerts() {
                $.ajax({
                    url: "ajax_notifications.php",
                    type: "POST",
                    data: {
                        update: 'CheckAlerts', userid: userid
                    },
                    success: function (data, textStatus, XMLHttpRequest) {
                        var response = $.parseJSON(data);

                        // Update the DOM to show the new alerts!
                        if (response.numberOfRequests > 0) {
                            // update the number in the DOM and make sure it is visible...
                            $('#mes').show().text(response.numberOfRequests);
                            $('#nav li:eq(0)').replaceWith(response.html);
                        }
                        else {
                            // Hide the number, since there are no pending friend requests
                            $('#mes').hide();
                            $('#nav li:eq(0)').replaceWith(response.html);
                        }

                        // Do something similar for unreadMessages, if required...
                    }
                });

            }

            $(document).on("click", "a[href='view_requests.php']", function () {
                $.ajax({
                    url: "ajax_notifications.php",
                    type: "POST",
                    data: {
                        update: 'seen', userid: userid
                    },
                    success: function (data) {
                        var response = $.parseJSON(data);

                        // Update the DOM to show the new alerts!
                        if (response.numberOfRequests > 0) {
                            // update the number in the DOM and make sure it is visible...
                            $('#mes').show().text(response.numberOfRequests);
                            $('#nav li:eq(0)').before(response.html);
                        }
                        else {
                            // Hide the number, since there are no pending friend requests
                            $('#mes').hide();
                            $('#nav li:eq(0)').before(response.html);
                        }

                        // Do something similar for unreadMessages, if required...
                    }
                });
            });
        </script>
        <script>


            $(document).on("keyup blur input change", "#ccode", function (e) {

                var customer_code = $(this).val();
               if (!(customer_code=== "")) {
                $.ajax({
                    type: "POST",
                    url: "test.php",
                    data: {"ccode": customer_code},
                    success: function (data) {
                        var opts = $.parseJSON(data);
                        if (opts.customer) {
                            $("#upgrade").show();
                            $("#cc").html("");
                        }
                        
                        else {
                            $("#upgrade").hide();
                            $("#cc").html("No Customer with such code").css("color","red");
                        }


                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + " " + thrownError);
                    }
                });
            } 
            
            else {
               $("#upgrade").hide(); 
                $("#cc").html("");
            }
                
            });

        </script>

    </body>

</html>
