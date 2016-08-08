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
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="main.php">Report System</a>    
                </div>
                <!-- /.navbar-header -->

                <ul id ="nav" class="nav navbar-top-links navbar-right">
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
                        <h1 class="page-header">Create new user</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form id="loginForm" role="form" action="user_processing.php" method="POST">
                                            <div class="form-group">
                                                <label>Username</label>

                                                <input id="username" type="text" name="username" class="form-control" placeholder="Username" value="<?php //echo $username                                                    ?>"/><span style="color:#ff0000"><?php //echo $error_username;                                                    ?></span><span style="color:#ff0000"><?php //echo $min_rr;                                                    ?></span>
                                            </div>
                                            <div id="uname"> </div>
                                            <div class="form-group">
                                                <label>password</label>
                                                <input id="password" type="password" name="password" class="form-control" placeholder="password" value="<?php //echo $password                                                    ?>"/><span style="color:#ff0000"><?php //echo $error_password;                                                    ?></span><span style="color:#ff0000"><?php //echo $err_pass;                                                    ?></span>
                                            </div>
                                            <div id="pass">  </div>
                                            <div class="form-group">
                                                <label>confirm password</label>
                                                <input id="re_password"  type="password" name="re_password" class="form-control" placeholder="confirm password" /><span style="color:#ff0000"><?php //echo $error_password_c;                                                    ?></span><span style="color:#ff0000"><?php //echo $err_passc;                                                    ?></span>
                                            </div>
                                            <div id="re_pass"> </div>
                                            <div class="form-group">
                                                <label>First name</label>
                                                <input id="fname" type="text" name="fname" class="form-control" placeholder="First name" value="<?php //echo $fname                                                    ?>"/><span style="color:#ff0000"><?php //echo $error_fname;                                                    ?></span>

                                            </div>
                                            <div id="fn"> </div>
                                            <div class="form-group">
                                                <label>Last name</label>
                                                <input id="lname" type="text" name="lname" class="form-control" placeholder="Last name" value=""/>                           

                                            </div>
                                            <div id="ln"> </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input id="email" type="text" name="email" class="form-control" placeholder="Email" value=""/>                                                                                     
                                                <p class="help-block">example:emma@example.com</p>
                                            </div>
                                            <div id="em"> </div>
                                            <div class="form-group">
                                                <label>Telephone</label>
                                                <input id="tel" type="text" name="tel" class="form-control" placeholder="Telephone" value=""/>                                                       
                                                <p class="help-block">example:0788303125</p>
                                            </div>
                                            <div id="phone"> </div>
                                            <div class="form-group">
                                                <label>Choose role or enter new</label>
                                                <input id="rol" type="text" list="role" name="taskoption" />
                                                <datalist id="role" >
                                                </datalist>
                                            </div>
                                            <div id="sel"> </div>

                                            <button type="submit" name="submit" class="btn btn-default">Save</button>
                                            <button type="reset" name="reset" class="btn btn-default">Cancel</button>
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

        <script src="bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="dist/js/sb-admin-2.js"></script>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $("#loginForm").submit(function (e) {
                    var firstnameLen = $("#fname").val().length < 1;
                    var LastnameLen = $("#lname").val().length < 1;
                    var emailLen = $("#email").val().length < 1;
                    var password = $("#password").val();
                    var passwordLen = $("#password").val().length < 1;
                    var Re_password = $("#re_password").val();
                    var Re_passwordLen = $("#re_password").val().length < 1;
                    var TelphoneLen = $("#tel").val().length < 1;
                    var username = $("#username").val();
                    var usernameLen = $("#username").val().length < 1;
                    var roleLen = $("#rol").val().length < 1;
                    var emailaddress = $("#email").val();
                    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                    var tel = $('#tel').val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
                    var telephone = $('#tel').val();
                    var intRegex = /^\d+$/;
                    if (firstnameLen || LastnameLen || emailLen || passwordLen || usernameLen || TelphoneLen || Re_passwordLen || roleLen) {
                        $("#fn").html(firstnameLen ? "First Name required" : "").css("color", "red");
                        $("#ln").html(LastnameLen ? "Last Name required" : "").css("color", "red");
                        $("#pass").html(passwordLen ? "Password required" : "").css("color", "red");
                        $("#re_pass").html(Re_passwordLen ? "Confirm Password required" : "").css("color", "red");
                        $("#phone").html(TelphoneLen ? "Phone Number required" : "").css("color", "red");
                        $("#em").html(emailLen ? "Email required" : "").css("color", "red");
                        $("#uname").html(usernameLen ? "Username required" : "").css("color", "red");
                        $("#sel").html(roleLen ? "Role required" : "").css("color", "red");
                        e.preventDefault();
                    }

                    if ($('#tel').val() !== "" || emailaddress !== "" || telephone !== "") {
                        if (!intRegex.test(tel)) {
                            $("#phone").html(!intRegex.test(tel) ? "Please Enter digits" : "").css("color", "red");
                            e.preventDefault();
                        }
                        else if (!testEmail.test(emailaddress)) {
                            $("#em").html(!testEmail.test(emailaddress) ? "Invalid Email" : "").css("color", "red");
                            e.preventDefault();
                        }
                        else if (telephone.length !== 10) {
                            $("#phone").html(telephone ? "Required 10 digits" : "").css("color", "red");
                            e.preventDefault();
                        }
                        else {
                        }

                    }
                    if (password !== "" || Re_password !== "") {
                        if (password !== Re_password) {
                            $("#re_pass").html("Password do not Match").css("color", "red");
                            e.preventDefault();
                        }
                    }

                    if (username !== "") {
                        $.ajax({
                            type: "POST",
                            url: "test.php",
                            data: {"id": "checkUsername", "username": username},
                            success: function (data) {
                                var opts = $.parseJSON(data);
                                if (opts !== false) {
                                    $("#uname").html(opts).css("color", "red");
                                    e.preventDefault();
                                }

                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            }
                        });
                    }

                });

                $.ajax({
                    type: "POST",
                    url: "test.php",
                    data: {"id": "role"},
                    success: function (data) {
                        var opts = $.parseJSON(data);
                        $.each(opts.roles, function (i, d) {

                            $('#role').append('<option value="' + opts.roles[i].name + '">' + opts.roles[i].name + '</option>');

                        });

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + " " + thrownError);
                    }
                });
                function check()
                {

                    var pass1 = document.getElementById('tel');


                    var message = document.getElementById('phone');

                    var goodColor = "white";
                    var badColor = "red";
                    if (pass1.value.length !== 10) {

                        pass1.style.backgroundColor = goodColor;
                        message.style.color = badColor;
                        message.innerHTML = "required 10 digits";
                    }
                    else {
                        message.innerHTML = "";
                        pass1.style.backgroundColor = goodColor;
                        message.style.color = goodColor;
                    }
                }

                $(document).on("keyup blur input", "#tel", function (e) {

                    check();
                });
            });
        </script>
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
        