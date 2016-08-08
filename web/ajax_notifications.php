<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php include("includes/functions.php"); ?>
<?php

if (null !== filter_input(INPUT_POST, "update") && null !== filter_input(INPUT_POST, "userid")) {
    $update = filter_input(INPUT_POST, "update");
    $userid = filter_input(INPUT_POST, "userid");
    $menus = find_menus_for_user($userid);
    $result = find_menuids($menus);
    switch ($update) {
        case 'CheckAlerts' :
            if ($result === 'tasksrequests') {
                $requests = find_all_requests(true);
                $num_request = count($requests);
                $assignments = find_all_assignments($userid, true);
                $num_assignments = count($assignments);
                $requesthtml = request_notifications($requests, $num_request);
                $taskhtml = task_notifications($assignments, $num_assignments);
                $login = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                $login.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                $login.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                $login.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                $html = $requesthtml . $taskhtml . $login;
                $response = array("numberOfRequests" => $num_request, "numberOfTasks" => $num_assignments, "html" => $html);
                echo json_encode($response);
            } else if ($result === 'requests') {
                $requests = find_all_requests(true);
                $num_request = count($requests);
                $requesthtml = request_notifications($requests, $num_request);
                $login = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                $login.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                $login.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                $login.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                $html = $requesthtml . $login;
                $response = array("numberOfRequests" => $num_request, "html" => $html);
                echo json_encode($response);
            } else if ($result === 'tasks') {
                $assignments = find_all_assignments($userid, true);
                $num_assignments = count($assignments);
                $taskhtml = task_notifications($assignments, $num_assignments);
                $login = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                $login.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                $login.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                $login.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                $html = $taskhtml . $login;
                $response = array("numberOfTasks" => $num_assignments, "html" => $html);
                echo json_encode($response);
            } else {
                $html = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                $html.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                $html.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                $html.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                $response = array("html" => $html);
                echo json_encode($response);
            }
            break;
        case 'requestseen' :
            if (Update_requests()) {
                if ($result === 'tasksrequests') {
                    $requests = find_all_requests(true);
                    $num_request = count($requests);
                    $assignments = find_all_assignments($userid, true);
                    $num_assignments = count($assignments);
                    $requesthtml = request_notifications($requests, $num_request);
                    $taskhtml = task_notifications($assignments, $num_assignments);
                    $login = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                    $login.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                    $login.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                    $login.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                    $html = $requesthtml . $taskhtml . $login;
                    $response = array("numberOfRequests" => $num_request, "numberOfTasks" => $num_assignments, "html" => $html);
                    echo json_encode($response);
                } else if ($result === 'requests') {
                    $requests = find_all_requests(true);
                    $num_request = count($requests);
                    $requesthtml = request_notifications($requests, $num_request);
                    $login = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                    $login.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                    $login.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                    $login.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                    $html = $requesthtml . $login;
                    $response = array("numberOfRequests" => $num_request, "html" => $html);
                    echo json_encode($response);
                } else if ($result === 'tasks') {
                    $assignments = find_all_assignments($userid, true);
                    $num_assignments = count($assignments);
                    $taskhtml = task_notifications($assignments, $num_assignments);
                    $login = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                    $login.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                    $login.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                    $login.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                    $html = $taskhtml . $login;
                    $response = array("numberOfTasks" => $num_assignments, "html" => $html);
                    echo json_encode($response);
                } else {
                    $html = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                    $html.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                    $html.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                    $html.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                    $response = array("html" => $html);
                    echo json_encode($response);
                }
            } else {
                echo json_encode("false");
            }
            break;
        case 'taskseen':
            if (Update_assignments($userid)) {
                if ($result === 'tasksrequests') {
                    $requests = find_all_requests(true);
                    $num_request = count($requests);
                    $assignments = find_all_assignments($userid, true);
                    $num_assignments = count($assignments);
                    $requesthtml = request_notifications($requests, $num_request);
                    $taskhtml = task_notifications($assignments, $num_assignments);
                    $login = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                    $login.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                    $login.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                    $login.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                    $html = $requesthtml . $taskhtml . $login;
                    $response = array("numberOfRequests" => $num_request, "numberOfTasks" => $num_assignments, "html" => $html);
                    echo json_encode($response);
                } else if ($result === 'requests') {
                    $requests = find_all_requests(true);
                    $num_request = count($requests);
                    $requesthtml = request_notifications($requests, $num_request);
                    $login = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                    $login.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                    $login.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                    $login.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                    $html = $requesthtml . $login;
                    $response = array("numberOfRequests" => $num_request, "html" => $html);
                    echo json_encode($response);
                } else if ($result === 'tasks') {
                    $assignments = find_all_assignments($userid, true);
                    $num_assignments = count($assignments);
                    $taskhtml = task_notifications($assignments, $num_assignments);
                    $login = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                    $login.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                    $login.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                    $login.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                    $html = $taskhtml . $login;
                    $response = array("numberOfTasks" => $num_assignments, "html" => $html);
                    echo json_encode($response);
                } else {
                    $html = "<li class=\"dropdown\" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i></a>";
                    $html.="<ul class=\"dropdown-menu dropdown-user\"  ><li><a href=\"myprofile.php\"><i class=\"fa fa-user fa-fw\"></i> My Profile</a></li>";
                    $html.="<li><a href=\"change_password.php\"><i class=\"fa fa-gear fa-fw\"></i> Change Password</a></li><li class=\"divider\"></li>";
                    $html.="<li><a href=\"login.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a></li></ul></li>";
                    $response = array("html" => $html);
                    echo json_encode($response);
                }
            } else {
                echo json_encode("false");
            }
            break;
        default:
            break;
    }
} else {
    
}    