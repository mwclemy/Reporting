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
                <div  class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="main.php">Report System</a>    
                </div>
                <ul id="nav" class="nav navbar-top-links navbar-right">
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

                </div>

            </nav>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"> Terminate Connection </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                            </div>
                            <div class="panel-body">
                                <div class="container">
                                    <div class="col-sm-7  well">
                                        <div class="form-inline">
                                            <div class="form-group col-sm-5">
                                                <input id="search" class="form-control" type="text" value="" placeholder="Search Customer" name="q">
                                                <div id="sear"></div>
                                            </div>
                                            <div class="form-group ">
                                                <select id="customer" class="form-control" name="category">
                                                    <option value=""> Search by </option>
                                                </select>
                                                <div id="cus"></div>
                                            </div>
                                            <button id="button" class="btn btn-primary col-sm-3 pull-right" type="submit">Search</button>
                                            <div id="notfound"> </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="contable"> </div>
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
        <script src="dist/js/form_validation.js"></script>
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


            $(document).ready(function () {
                $.ajax({
                    type: "POST",
                    url: "test.php",
                    data: {"id": "customer"},
                    success: function (data) {
                        var opts = $.parseJSON(data);
                        $.each(opts.keys, function (i, d) {

                            $('#customer').append('<option value="' + opts.keys[i] + '">' + opts.keys[i] + '</option>');
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + " " + thrownError);
                    }
                });
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
        <script type="text/javascript">
            $(document).on("click", "#button", function (e) {

                var search = $('#search').val();
                var choice = $('#customer').val();
                var requestype = "terminate";
                if ((search !== "") && choice !== "") {
                    $("#sear").html("").css("color", "red");
                    $("#cus").html("").css("color", "red");
                    $.ajax({
                        type: "POST",
                        url: "test.php",
                        data: {"search": search, "choice": choice, "request_type": requestype}
                        ,
                        success: function (data) {
                            var opts = $.parseJSON(data);
                            if (opts.connections === null) {
                                $("#notfound").html("").css("color", "red");
                                $("#contable").html("No connection Found").css("color", "red");
                            }

                            else if (opts.connections === false) {
                                $("#contable").html("").css("color", "red");
                                $("#notfound").html("No Customer Found").css("color", "red");
                            }
                            else {
                                $("#notfound").html("").css("color", "red");
                                $("#contable").html(opts.connections);
                            }


                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        }
                    });
                }

                else {
                    $("#sear").html("Enter a search").css("color", "red");
                    $("#cus").html("Please Select").css("color", "red");
                }

            });


            $(document).on("click", ".submit", function () {
                var connection = $(this).closest('tr').attr('id');
                var arr = connection.split('_');
                var connectionid = arr[0];
                var requestid = arr[1];
                var customerid = arr[2];
                var comment = $('#' + connection + ' .comm').val();
                // Make an ajax request to request_processing.php
                $.ajax({
                    type: "POST",
                    url: "request_processing.php?request_type=Terminate",
                    data: {"connection_id": connectionid, "request_id": requestid, "customer_id": customerid, "comm": comment}
                    ,
                    success: function (data) {
                        var opts = $.parseJSON(data);
                        if (opts === true) {
                            window.location.href = "http://localhost/Reporting/web/main.php";
                        }

                    }
                });


            });
        </script>

        <?php
        include("includes/footer.php");
        