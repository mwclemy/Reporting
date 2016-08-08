<?php

// this starts a session.
session_start();

// formats and returns any system message.
function message() {
    if (isset($_SESSION["message"])) {
        $output = "<p id=\"message\" class=\" alert alert-success\"> ";
        $output.= htmlentities($_SESSION["message"]);
        $output .="</p> ";
//clear message after use.
        $_SESSION["message"] = null;
        return $output;
    }
}

// checks if the 
function is_checked($userid, $menuid) {
    // gets the row from the user_menus table.
    $user_menu = does_this_exist($userid, $menuid);
    // gets the value in the checked field.
    $checked = (int) $user_menu['checked'];
    if ($checked === 1) {
        return true;
    } else {
        return false;
    }
}

// the head of the user_permissions page's table.
function table_heading($menus, $num_menus) {
    $html = "<table class=\"table\"><thead><tr>";
    $html.="<th>User FullName</th><th>Role</th>";
    for ($count = 0; $count < $num_menus; $count++) {
        $html.="<th>";
        $html.=$menus[$count]["menu_name"];
        $html.="</th>";
    }
    $html.="<th></th>";
    $html.="</tr></thead>";
    $html.="<tbody>";
    return $html;
}

// the body of the user_permissions page's table.
function table_body($users, $num_users, $menus, $num_menus) {
    $html = "";
    for ($user = 0; $user < $num_users; $user++) {
        $html.= "<tr><td>";
        $html.=htmlentities($users[$user]["fname"]) . " " . htmlentities($users[$user]["lname"]);
        $html.="</td><td>";
        $html.=htmlentities(find_rolename_by_userid($users[$user]["user_id"]));
        $html.="</td>";
        for ($menu = 0; $menu < $num_menus; $menu++) {
            $html.="<td><input id=\"";
            $html.=$users[$user]["user_id"] . "_" . $menus[$menu]["menu_id"];
            $html.="\" class=\"check\" type=\"checkbox\"" . " ";
            $html.=(is_checked($users[$user]["user_id"], $menus[$menu]["menu_id"])) ? ' checked' : '';
            $html.= "/></td>";
        }
        $html.="<td></td></tr>";
    }
    $html.="</tbody></table>";
    return $html;
}

// the table on the user_permissions page.
function permissions_table() {
    $users = find_all_users();
    $menus = find_all_menus();
    $num_users = count($users);
    $num_menus = count($menus);
    if ($num_users > 0) {
        $html = table_heading($menus, $num_menus);
        $html.=table_body($users, $num_users, $menus, $num_menus);
        $html.="<button id=\"save\" style=\"float:right;\" type=\"submit\" class=\"btn btn-default\" name=\"submit\" value=\"submit\">";
        $html.="Save Changes</button><div> <strong>Note:</strong> The access matrix gets updated upon clicking. </div>";
        return $html;
    } else {
        $_SESSION["message"] = "Oops No users!!!!";
        return message();
    }
}

// find all assignments made on the given request
function find_assignments_by_requestid($request_id) {
    global $connection;
    $query = "SELECT * FROM assignments WHERE request_id={$request_id} ";
    $assignment_set = mysqli_query($connection, $query);
    confirm_query($assignment_set);
    $num_assignments = mysqli_num_rows($assignment_set);
    if ($num_assignments > 0) {
        for ($count = 0; $count < $num_assignments; $count++) {
            $assignments[$count] = mysqli_fetch_assoc($assignment_set);
        }
        return $assignments;
    } else {
        return null;
    }
}

// Get the datamanager associated with the request
function Get_datamanager($request) {
    $assignments = find_assignments_by_requestid($request["request_id"]);
    $num_assignments = count($assignments);
    if ($num_assignments > 0) {
        for ($counter = 0; $counter < $num_assignments; $counter++) {
            if ($assignments[$counter]["assigned_task"] === $request["task"]) {
                $user = find_user_by_id($assignments[$counter]["data_manager_id"]);
            }
        }
        return (isset($user) ? $user : null);
    } else {
        return null;
    }
}

function date_dif($request, $complete) {
    if ($complete !== null) {
        $datetime1 = new DateTime($complete);
        $datetime2 = new DateTime($request);
        $interval = $datetime1->diff($datetime2);
        return $interval->format('%R%a days');
    } else {
        $datetime1 = new DateTime();
        $datetime2 = new DateTime($request);
        $interval = $datetime1->diff($datetime2);
        return $interval->format('%R%a days');
    }
}

// the datamanager's most current comment on the request
function current_comment($request_id, $data_managerid) {
    global $connection;
    $query = "SELECT * FROM comments AS c INNER JOIN assignments AS a ON c.assign_id=a.assign_id  ";
    $query.= "WHERE a.data_manager_id={$data_managerid} AND a.request_id={$request_id}  ";
    $query.="ORDER BY c.comment_date DESC LIMIT 1";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $row = mysqli_fetch_assoc($result);
    if ($row !== null) {
        return $row;
    } else {
        return null;
    }
}

function find_connection_by_requestid($request_id) {
    global $connection;
    $query = "SELECT * FROM connections WHERE request_id={$request_id} LIMIT 1 ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $row = mysqli_fetch_assoc($result);
    if ($row !== null) {
        return $row;
    } else {
        return null;
    }
}

// the body of the view status page's table.
function status_body($requests, $num_request) {
    $output = "";
    for ($count = 0; $count < $num_request; $count++) {
        $data_manager = Get_datamanager($requests[$count]);
        $current_comment = ($data_manager !== null ? current_comment($requests[$count]["request_id"], $data_manager["user_id"]) : null);
        $connection = find_connection_by_requestid($requests[$count]["request_id"]);
        $output.="<tr><td>" . htmlentities($requests[$count]["full_name"]) . "</td>";
        // $output.="<td>" . htmlentities($requests[$count]["location"]) . "</td>";
        $output.="<td>" . htmlentities($requests[$count]["contact"]) . "</td>";
        $output.="<td>" . htmlentities($requests[$count]["technology"]) . "</td>";
        $output.="<td>" . htmlentities($requests[$count]["service"]) . "</td>";
        $output.="<td>" . htmlentities($requests[$count]["new_package"]) . "</td>";
        $output.="<td>" . htmlentities($requests[$count]["request_type"]) . "</td>";
        $output.="<td>" . htmlentities($requests[$count]["task"]) . "</td>";
        $output.="<td>" . ($data_manager !== null ? htmlentities($data_manager["fname"]) . " " . htmlentities($data_manager["lname"]) : "----- " ) . "</td>";
        $output.="<td>" . htmlentities(date_dif($requests[$count]["request_date"], $connection["connection_date"])) . "</td>";
        $output.="<td>" . ($current_comment !== null ? htmlentities($current_comment["comm"]) : "-----") . "</td>";
        $output.="<td>" . ($connection["connection_date"] !== null ? htmlentities($connection["connection_date"]) : "------") . "</td>";
        $output.="<td>" . htmlentities($requests[$count]["request_marked_as"]) . "</td></tr>";
    }
    return $output;
}

// the table on the view status page.
function status_table($requests) {
    $num_request = count($requests);
    $output = "<table class = \"table table-striped table-bordered table-hover\" id = \"dataTables-example\"><thead><tr>";
    $output.="<th>Customer Name</th><th>Contact</th><th>Technology </th><th>Service </th><th>Package</th><th>Request Type </th>";
    $output.="<th>Required Task </th><th>Assigned Data Manager </th><th>Edge</th><th>Comment</th><th>Completion Date</th><th>Status</th></tr></thead><tbody>";
    $output.=status_body($requests, $num_request);
    $output.="</tbody></table>";
    return $output;
}

// the table on the manage users page.
function users_table() {
    $users = find_all_users();
    $num_users = count($users);
    $html = "<table class = \"table \"><thead><tr>";
    $html.="<th>Full Name</th><th>Username</th><th>Email</th><th>Phone Number</th><th>Job Title</th><th  colspan=\"2\" style=\"text-align: left;\">  Actions </th></tr></thead>";
    $html.= "<tbody>";
    for ($count = 0; $count < $num_users; $count++) {
        $html.="<tr><td>" . htmlentities($users[$count]["fname"]) . " " . htmlentities($users[$count]["lname"]) . "</td>";
        $html.="<td>" . htmlentities($users[$count]["username"]) . "</td>";
        $html.="<td>" . htmlentities($users[$count]["email"]) . "</td>";
        $html.="<td>" . htmlentities($users[$count]["tel"]) . "</td>";
        $html.="<td>" . htmlentities(find_rolename_by_userid($users[$count]["user_id"])) . "</td>";
        $html.="<td> <a href = \"edit_user.php?id=" . urlencode($users[$count]["user_id"]) . "\" > Edit </a> </td>";
        $html.="<td> <a href =\"delete_user.php?id=" . urlencode($users[$count]["user_id"]) . "\"onclick = \"return confirm('Are you sure you want to delete this user?');\"> Delete </a> </td></tr>";
    }
    $html.="</tbody></table>";
    return $html;
}

// finds and returns errors if are set in the errore SESSION.
function errors() {
    if (isset($_SESSION["errors"])) {

        $errors = $_SESSION["errors"];

//clear message after use.
        $_SESSION["errors"] = null;
        return $errors;
    }
}

// Get user's role by his/her id.
function find_rolename_by_userid($userid) {
    global $connection;
    $query = "SELECT role_name ";
    $query.="FROM roles As r ";
    $query.="INNER JOIN users AS u ";
    $query.="ON r.role_id = u.role_id ";
    $query.="WHERE u.user_id = {$userid} ";
    $role_set = mysqli_query($connection, $query);
    confirm_query($role_set);
    $rolename = mysqli_fetch_assoc($role_set);
    return $rolename["role_name"];
}

// Get the user given his/her id.
function find_user_by_id($userid) {
    global $connection;
    $query = "SELECT *  ";
    $query.="FROM users  ";
    $query.="WHERE  user_id={$userid}  ";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    $num_users = mysqli_num_rows($user_set);
    if ($num_users > 0) {
        $user = mysqli_fetch_assoc($user_set);
        return $user;
    } else {
        return null;
    }
}

// formats and returns the welcome message of the main page.
function welcome_message() {
    if (isset($_SESSION["user_id"])) {
        $user = find_user_by_id($_SESSION["user_id"]);
        $rolename = find_rolename_by_userid($user["user_id"]);
        $output = "<span id=\"welcome\" class=\" alert alert-success\">";
        $output.=" Welcome to the Reporting System " . $user["fname"] . "  " . $user["lname"];
        $output.=",&nbsp; &nbsp; ";
        $output.= "You have  logged in as:" . $rolename;
        $output.="</span>";

        return $output;
    }
}

// Gets the user id stored in the user_id SESSION.
function get_userid() {
    if (isset($_SESSION["user_id"])) {
        $userid = $_SESSION["user_id"];
        return $userid;
    } else {
        return null;
    }
}
