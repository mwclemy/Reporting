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
        <title>Reporting System </title>
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="dist/css/sb-admin-2.css" rel="stylesheet">
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
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="main.php">Reporting System </a>  
                </div>
                <div>
                    <ul id="nav" class="nav navbar-top-links navbar-right ">
                        <li> </li>
                        <li class="dropdown" >
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user"  >
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
                </div>
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">

                        <ul class="nav" id="side-menu" >
                            <li>
                                <a href="main.php" class="active" > HOME </a>
                            </li>
                            <?php echo navigation($userid) ?> 
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo message() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"> Change Password</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Change Password
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form role="form" id="loginForm" method="POST" action="credential_processing.php">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input id="password" class="form-control" name="password" placeholder="Enter New Password" type="password">
                                                <div id="pass"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input id="repassword" class="form-control" name="repassword" placeholder="Confirm Password" type="password">
                                                <div id="repass"> </div>
                                            </div>
                                            <button type="submit" class="btn btn-default" name="submit" value="submit">Change</button>
                                            <button type="reset" class="btn btn-default">Cancel</button>
                                        </form>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
        <script src="dist/js/sb-admin-2.js"></script>
        <script type="text/javascript">
            var userid = "<?php echo $userid; ?>";
            $(document).ready(function () {
                updateAlerts();
                window.setInterval(function () {
                    updateAlerts();
                }, 10000);

            });
            function updateAlerts() {
                $.ajax({
                    url: "ajax_notifications.php",
                    type: "POST",
                    data: {
                        "update": 'CheckAlerts', "userid": userid
                    }
                    ,
                    success: function (data, textStatus, XMLHttpRequest) {
                        var response = $.parseJSON(data);

                        // Update the DOM to show the new alerts!
                        if (typeof response.numberOfRequests !== 'undefined' && typeof response.numberOfTasks !== 'undefined') {
                            $('#notifications').show();
                            if (response.numberOfRequests > 0 && response.numberOfTasks > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').show().text(response.numberOfRequests);
                                $('#taskmes').show().text(response.numberOfTasks);
                                $('#tasknot').show().text(response.numberOfTasks);
                                $('#requestnot').show().text(response.numberOfRequests);
                            }
                            else if (response.numberOfRequests > 0 && response.numberOfTasks <= 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').show().text(response.numberOfRequests);
                                $('#taskmes').hide();
                                $('#tasknot').show().text('No');
                                $('#requestnot').show().text(response.numberOfRequests);
                            }
                            else if (response.numberOfRequests <= 0 && response.numberOfTasks > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').hide();
                                $('#taskmes').show().text(response.numberOfTasks);
                                $('#tasknot').show().text(response.numberOfTasks);
                                $('#requestnot').show().text('No');
                            }
                            else {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').hide();
                                $('#taskmes').hide();
                                $('#tasknot').show().text('No');
                                $('#requestnot').show().text('No');
                            }

                        }
                        else if (typeof response.numberOfRequests !== 'undefined' && typeof response.numberOfTasks === 'undefined') {
                            $('#notifications').show();
                            if (response.numberOfRequests > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').show().text(response.numberOfRequests);
                                $('#requestnot').show().text(response.numberOfRequests);
                                $('#task').hide();
                            }
                            else {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').hide();
                                $('#requestnot').show().text('No');
                                $('#task').hide();
                            }
                        }
                        else if (typeof response.numberOfRequests === 'undefined' && typeof response.numberOfTasks !== 'undefined') {
                            $('#notifications').show();
                            if (response.numberOfTasks > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#taskmes').show().text(response.numberOfTasks);
                                $('#tasknot').show().text(response.numberOfTasks);
                                $('#request').hide();
                            }
                            else {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#taskmes').hide();
                                $('#tasknot').show().text('No');
                                $('#request').hide();
                            }
                        }

                        else {
                            $('.dropdown').remove();
                            $('#notifications').hide();
                            $('#nav').append(response.html);
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
                        update: 'requestseen', userid: userid
                    },
                    success: function (data) {
                        var response = $.parseJSON(data);

                        // Update the DOM to show the new alerts!
                        if (typeof response.numberOfRequests !== 'undefined' && typeof response.numberOfTasks !== 'undefined') {
                            $('#notifications').show();
                            if (response.numberOfRequests > 0 && response.numberOfTasks > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').show().text(response.numberOfRequests);
                                $('#taskmes').show().text(response.numberOfTasks);
                                $('#tasknot').show().text(response.numberOfTasks);
                                $('#requestnot').show().text(response.numberOfRequests);
                            }
                            else if (response.numberOfRequests > 0 && response.numberOfTasks <= 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').show().text(response.numberOfRequests);
                                $('#taskmes').hide();
                                $('#tasknot').show().text('No');
                                $('#requestnot').show().text(response.numberOfRequests);
                            }
                            else if (response.numberOfRequests <= 0 && response.numberOfTasks > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').hide();
                                $('#taskmes').show().text(response.numberOfTasks);
                                $('#tasknot').show().text(response.numberOfTasks);
                                $('#requestnot').show().text('No');
                            }
                            else {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').hide();
                                $('#taskmes').hide();
                                $('#tasknot').show().text('No');
                                $('#requestnot').show().text('No');
                            }

                        }
                        else if (typeof response.numberOfRequests !== 'undefined' && typeof response.numberOfTasks === 'undefined') {
                            $('#notifications').show();
                            if (response.numberOfRequests > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').show().text(response.numberOfRequests);
                                $('#requestnot').show().text(response.numberOfRequests);
                                $('#task').hide();
                            }
                            else {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').hide();
                                $('#requestnot').show().text('No');
                                $('#task').hide();
                            }
                        }
                        else if (typeof response.numberOfRequests === 'undefined' && typeof response.numberOfTasks !== 'undefined') {
                            $('#notifications').show();
                            if (response.numberOfTasks > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#taskmes').show().text(response.numberOfTasks);
                                $('#tasknot').show().text(response.numberOfTasks);
                                $('#request').hide();
                            }
                            else {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#taskmes').hide();
                                $('#tasknot').show().text('No');
                                $('#request').hide();
                            }
                        }

                        else {
                            $('.dropdown').remove();
                            $('#notifications').hide();
                            $('#nav').append(response.html);
                        }
                        // Do something similar for unreadMessages, if required...
                    }
                });

            });

            $(document).on("click", "a[href='view_tasks.php']", function () {
                $.ajax({
                    url: "ajax_notifications.php",
                    type: "POST",
                    data: {
                        update: 'taskseen', userid: userid
                    },
                    success: function (data) {
                        var response = $.parseJSON(data);

                        // Update the DOM to show the new alerts!
                        if (typeof response.numberOfRequests !== 'undefined' && typeof response.numberOfTasks !== 'undefined') {
                            $('#notifications').show();
                            if (response.numberOfRequests > 0 && response.numberOfTasks > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').show().text(response.numberOfRequests);
                                $('#taskmes').show().text(response.numberOfTasks);
                                $('#tasknot').show().text(response.numberOfTasks);
                                $('#requestnot').show().text(response.numberOfRequests);
                            }
                            else if (response.numberOfRequests > 0 && response.numberOfTasks <= 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').show().text(response.numberOfRequests);
                                $('#taskmes').hide();
                                $('#tasknot').show().text('No');
                                $('#requestnot').show().text(response.numberOfRequests);
                            }
                            else if (response.numberOfRequests <= 0 && response.numberOfTasks > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').hide();
                                $('#taskmes').show().text(response.numberOfTasks);
                                $('#tasknot').show().text(response.numberOfTasks);
                                $('#requestnot').show().text('No');
                            }
                            else {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').hide();
                                $('#taskmes').hide();
                                $('#tasknot').show().text('No');
                                $('#requestnot').show().text('No');
                            }

                        }
                        else if (typeof response.numberOfRequests !== 'undefined' && typeof response.numberOfTasks === 'undefined') {
                            $('#notifications').show();
                            if (response.numberOfRequests > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').show().text(response.numberOfRequests);
                                $('#requestnot').show().text(response.numberOfRequests);
                                $('#task').hide();
                            }
                            else {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#requestmes').hide();
                                $('#requestnot').show().text('No');
                                $('#task').hide();
                            }
                        }
                        else if (typeof response.numberOfRequests === 'undefined' && typeof response.numberOfTasks !== 'undefined') {
                            $('#notifications').show();
                            if (response.numberOfTasks > 0) {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#taskmes').show().text(response.numberOfTasks);
                                $('#tasknot').show().text(response.numberOfTasks);
                                $('#request').hide();
                            }
                            else {
                                $('.dropdown').remove();
                                $('#nav').append(response.html);
                                $('#taskmes').hide();
                                $('#tasknot').show().text('No');
                                $('#request').hide();
                            }
                        }

                        else {
                            $('.dropdown').remove();
                            $('#notifications').hide();
                            $('#nav').append(response.html);
                        }
                        // Do something similar for unreadMessages, if required...
                    }
                });

            });

            $("#loginForm").submit(function (e) {
                var password = $("#password").val();
                var repassword = $("#repassword").val();
                if (password.length < 1 || repassword.length < 1) {
                    $("#pass").html(password.length < 1 ? "Password required" : "").css("color", "red");
                    $("#repass").html(repassword.length < 1 ? "Password required" : "").css("color", "red");
                    e.preventDefault();
                }
                if (password !== "" && repassword !== "") {
                    if (password !== repassword) {
                        $("#repass").html("Password do not match!").css("color", "red");
                        $("#pass").html();
                        e.preventDefault();
                    }
                }
            });


        </script>

     <?php
        include("includes/footer.php");
