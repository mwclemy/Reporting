<?php require_once("includes/session.php"); ?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title> REPORTING SYSTEM </title>

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

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <form id="LoginForm" method="POST" role="form" action="login_processing.php">
                                <fieldset>
                                    <div class="form-group">
                                        <input id="username" class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                    </div>
                                    <div id="usname" style="color:red;">  </div>

                                    <div class="form-group">
                                        <input id="password" class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    <div id="pass" style="color:red;" >  </div>
                                    <?php echo message(); ?>

                                    <button id="btnValidate"  type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="submit">Login</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="dist/js/sb-admin-2.js"></script>

        <script type="text/javascript">
            // preventing the submission to occur while there are still errors in the form
            $('#LoginForm').submit(function (e) {
                var pass = $("#password").val();
                var username = $("#username").val();
                if (pass.length < 1 || username.length < 1) {
                    $("#pass").html(pass.length < 1 ? "Password required" : "").css("color", "red");
                    $("#usname").html(username.length < 1 ? "Username required" : "").css("color", "red");
                    $("#message").remove();
                    e.preventDefault();
                }

                else {
                    $("#pass").html("");
                    $("#usname").html("");
                }

            });



        </script>

    </body>

</html>
