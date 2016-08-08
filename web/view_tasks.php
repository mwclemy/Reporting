<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php include("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $userid = get_userid(); ?>
<?php $seen_assignments = find_all_assignments($userid, 'seen'); ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title> Reporting System </title>

        <!-- Bootstrap Core CSS -->
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

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
                    <a class="navbar-brand" href="main.php">Reporting System </a>
                </div>
                <!-- /.navbar-header -->

                <ul id="nav" class="nav navbar-top-links navbar-right">
                    <li></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="myprofile.php"><i class="fa fa-user fa-fw"></i> My profile</a>
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
                                <a href="main.php"> HOME</a>
                            </li>
                            <?php echo navigation($userid) ?> 
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">You can change Status</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Tasks by me
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="tab">
                                    <?php echo task_table($seen_assignments); ?>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

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

        <!-- DataTables JavaScript -->
        <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="dist/js/sb-admin-2.js"></script>
        <script type="text/javascript">
            var userid = "<?php echo $userid; ?>";
            var tbody = $("#tab tbody");
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
            $(document).ready(function () {
                if (tbody.children().length === 0) {
                    $('#tab table').replaceWith("No task!!!");
                }
            });
            $(document).ready(function () {
                $.ajax({
                    type: "POST",
                    url: "test.php",
                    data: {"id": "change"},
                    success: function (data) {
                        var opts = $.parseJSON(data);
                        $.each(opts.status, function (i, d) {

                            $('.change').append('<option value="' + opts.status[i].status_id + '">' + opts.status[i].status_name + '</option>');
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + " " + thrownError);
                    }
                });
            });

            $('button[type=submit]').click(function (e) {
                var trid = $(this).closest('tr').attr('id');
                var arr = trid.split('_');
                var assignmentid = arr[0];
                var requestid = arr[1];
                var statusid = $('#' + trid + ' td' + ' select' + ' option:selected').val();
                var comment = $('#' + trid + ' td' + ' input.comm').val();
                // validations
                if (statusid.length < 1) {
                    $('#' + trid + ' td' + ' div.status').html("Choose Status").css("color", "red");
                    e.preventDefault();
                }
// No errors found
                else {
                    $('#' + trid + ' td' + ' div.status').html("").css("color", "red");
                    $.ajax({
                        type: "POST",
                        url: "test.php",
                        data: {"request_id": requestid, "assignmentid": assignmentid, "statusid": statusid, "data_manager_comment": comment}
                        ,
                        success: function (data) {
                            var opts = $.parseJSON(data);

                            if (opts === "true") {
                                $('#' + trid).remove();
                                if (tbody.children().length === 0) {
                                    $('#tab table').replaceWith("You are done!!!");
                                }
                            }
                            else {

                            }

                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        }
                    });
                }

            });
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
        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>
        <?php
        include("includes/footer.php");
        