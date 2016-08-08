<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php include("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
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
        <link rel="stylesheet" href="jquery-ui-themes-1.11.4/themes/smoothness/jquery-ui.css">

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
                        <li class="dropdown"> </li>
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
                        <h1 class="page-header"></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo message() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Manage Users
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php echo users_table(); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="jquery-ui-themes-1.11.4/jquery-1.10.2.js"></script>
        <script src="jquery-ui-themes-1.11.4/jquery-ui.js"></script>
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

        </script>

        <?php
        include("includes/footer.php");

        