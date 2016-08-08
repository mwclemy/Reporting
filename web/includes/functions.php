<?php

function redirect_to($new_location) {
    header("Location:  " . $new_location);
    exit;
}

function mysql_prep($string) {
    global $connection;
    $escaped_string = mysqli_real_escape_string($connection, $string);
    return $escaped_string;
}

function confirm_query($result_set) {
    global $connection;
    if (!$result_set) {
        die("database querry failed " . mysqli_error($connection));
    }
}

function url_str($fieldname) {
    $lowercase = strtolower($fieldname);
    $replaced_fieldname = str_replace(" ", "_", $lowercase);

    return $replaced_fieldname;
}
//function form_errors($errors = array()) {
//    $output = "";
//    if (!empty($errors)) {
//        $output.=" <div class=\"error\">";
//        $output.="Please fix the following errors:";
//        $output.="<ul>";
//        foreach ($errors as $key => $error) {
//            $output .="<li>";
//            $output .=htmlentities($error);
//            $output .="</li>";
//        }
//        $output .="</ul>";
//        $output .="</div>";
//    }
//    return $output;
//}

function find_all_status() {
    global $connection;
    $query = "SELECT *   ";
    $query.="FROM status ";
    $status_set = mysqli_query($connection, $query);
    confirm_query($status_set);
    $num_status = mysqli_num_rows($status_set);
    if ($num_status > 0) {
        for ($count = 0; $count < $num_status; $count++) {
            $row = mysqli_fetch_assoc($status_set);
            $status[$count] = $row;
        }
        return $status;
    } else {
        return null;
    }
}

function find_all_roles() {
    global $connection;
    $query = "SELECT *   ";
    $query.="FROM roles ";
    $role_set = mysqli_query($connection, $query);
    confirm_query($role_set);
    return $role_set;
}

function find_all_technology() {
    global $connection;
    $query = "SELECT *   ";
    $query.="FROM technology ";
    $technology_set = mysqli_query($connection, $query);
    confirm_query($technology_set);
    return $technology_set;
}

function find_all_services() {
    global $connection;
    $query = "SELECT *   ";
    $query.="FROM service ";
    $service_set = mysqli_query($connection, $query);
    confirm_query($service_set);
    return $service_set;
}

function find_comments_by_assignid($assign_id) {
    global $connection;
    $query = "SELECT *   ";
    $query.="FROM comments WHERE assign_id = $assign_id";
    $comment_set = mysqli_query($connection, $query);
    confirm_query($comment_set);
    $num_comments = mysqli_num_rows($comment_set);
    if ($num_comments > 0) {
        for ($count = 0; $count < $num_comments; $count++) {
            $row = mysqli_fetch_assoc($comment_set);
            $comments[$count] = $row;
        }
        return $comments;
    } else {
        return null;
    }
}

function find_all_customers() {
    global $connection;
    $query = "SELECT *   ";
    $query.="FROM customers ";
    $customer_set = mysqli_query($connection, $query);
    confirm_query($customer_set);
    $num_customers = mysqli_num_rows($customer_set);
    if ($num_customers > 0) {
        for ($count = 0; $count < $num_customers; $count++) {
            $row = mysqli_fetch_assoc($customer_set);
            $customers[$count] = $row;
        }
        mysqli_free_result($customer_set);
        return $customers;
    } else {
        mysqli_free_result($customer_set);
        return null;
    }
}

function find_all_customer_fields() {
    global $connection;
    $query = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='report' AND `TABLE_NAME`='customers' ";
    $customer_set = mysqli_query($connection, $query);
    confirm_query($customer_set);
    $num_fields = mysqli_num_rows($customer_set);
    if ($num_fields > 0) {
        for ($count = 0; $count < $num_fields; $count++) {
            $row = mysqli_fetch_assoc($customer_set);
            $fields[$count] = $row;
        }
        mysqli_free_result($customer_set);
        return $fields;
    } else {
        mysqli_free_result($customer_set);
        return null;
    }
}

function find_all_engineers() {
    global $connection;
    $query = "SELECT u.user_id,u.fname,u.lname  FROM users AS u ";
    $query.="INNER JOIN user_menus AS um ON u.user_id= um.user_id  ";
    $query.="INNER JOIN menus AS m ON um.menu_id= m.menu_id  ";
    $query.="WHERE m.menu_id= 11 AND um.checked=1 ";
    $engineers_set = mysqli_query($connection, $query);
    confirm_query($engineers_set);
    $num_engineers = mysqli_num_rows($engineers_set);
    if ($num_engineers > 0) {
        for ($count = 0; $count < $num_engineers; $count++) {
            $row = mysqli_fetch_assoc($engineers_set);
            $engineers[$count] = $row;
        }
        mysqli_free_result($engineers_set);
        return $engineers;
    } else {
        mysqli_free_result($engineers_set);
        return null;
    }
}

function find_all_users() {
    global $connection;
    $query = "SELECT *   ";
    $query.="FROM users  ";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    $num_users = mysqli_num_rows($user_set);
    if ($num_users > 0) {
        for ($count = 0; $count < $num_users; $count++) {
            $row = mysqli_fetch_assoc($user_set);
            $users[$count] = $row;
        }
        mysqli_free_result($user_set);
        return $users;
    } else {
        mysqli_free_result($user_set);
        return null;
    }
}

function find_all_from_users($userid) {
    global $connection;
    $query = "SELECT *   ";
    $query.="FROM users  ";
    $query.="WHERE user_id=$userid ";
    $query.="LIMIT 1 ";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    $user = mysqli_fetch_assoc($user_set);
    if ($user) {
        return $user;
    }
}

function find_page_by_id($page_id, $public = true) {
    global $connection;
    $safe_page_id = mysqli_real_escape_string($connection, $page_id);
    $query = "SELECT *   ";
    $query.="FROM pages  ";
    $query.="WHERE id= {$safe_page_id}  ";
    if ($public) {
        $query.="AND visible=1 ";
    }
    $query.="LIMIT 1 ";
    $page_set = mysqli_query($connection, $query);
    confirm_query($page_set);
    if ($page = mysqli_fetch_assoc($page_set)) {
        return $page;
    } else {
        return null;
    }
}

function find_titleid_by_titlename($titlename) {
    global $connection;

    $query = "SELECT title_id  ";
    $query.="FROM title ";
    $query.="WHERE title_name= '{$titlename}'  ";
    $query.="LIMIT 1 ";
    $titleid_set = mysqli_query($connection, $query);
    confirm_query($titleid_set);
    if ($titleid = mysqli_fetch_assoc($titleid_set)) {
        return $titleid;
    } else {
        return null;
    }
}

function find_roleid_by_rolename($rolename) {
    global $connection;
    $query = "SELECT role_id  ";
    $query.="FROM roles ";
    $query.="WHERE role_name= '{$rolename}'  ";
    $query.="LIMIT 1 ";
    $roleid_set = mysqli_query($connection, $query);
    confirm_query($roleid_set);
    $roleid = mysqli_fetch_assoc($roleid_set);
    if ($roleid !== null) {
        return $roleid["role_id"];
    } else {
        return null;
    }
}


function find_user_by_email($email) {
    global $connection;

    $query = "SELECT *   ";
    $query.="FROM users  ";
    $query.="WHERE email= '{$email}'  ";
    $query.="LIMIT 1 ";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    $user = mysqli_fetch_assoc($user_set);
    if ($user !== null) {
        return $user;
    } else {
        return null;
    }
}

function find_user_by_phone($phone) {
        global $connection;
        $query = "SELECT *   ";
        $query.="FROM users  ";
        $query.="WHERE tel= '{$phone}'  ";
        $query.="LIMIT 1 ";
        $user_set = mysqli_query($connection, $query);
        confirm_query($user_set);
        $user = mysqli_fetch_assoc($user_set);
        if ($user !== null) {
            return $user;
        } else {
            return null;
        }
    }

function find_user_by_username($username) {
    global $connection;

    $query = "SELECT *   ";
    $query.="FROM users  ";
    $query.="WHERE username= '{$username}'  ";
    $query.="LIMIT 1 ";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    $user = mysqli_fetch_assoc($user_set);
    if ($user !== null) {
        return $user;
    } else {
        return null;
    }
}

function find_all_menus() {
    global $connection;
    $query = "SELECT * ";
    $query.="FROM menus ";
    $menu_set = mysqli_query($connection, $query);
    confirm_query($menu_set);
    $num_menus = mysqli_num_rows($menu_set);
    if ($num_menus > 0) {
        for ($count = 0; $count < $num_menus; $count++) {
            $row = mysqli_fetch_assoc($menu_set);
            $menus[$count] = $row;
        }
        return $menus;
    } else {
        return null;
    }
}

function find_menus_for_user($userid) {
    global $connection;
    $query = "SELECT * FROM users As u ";
    $query.="INNER JOIN user_menus AS um ON um.user_id = u.user_id ";
    $query.="INNER JOIN menus AS m ON um.menu_id = m.menu_id ";
    $query.="WHERE u.user_id = {$userid} AND checked= 1 ";
    $query.="ORDER BY m.menu_name ASC ";
    $menu_set = mysqli_query($connection, $query);
    confirm_query($menu_set);
    $num_menus = mysqli_num_rows($menu_set);
    if ($num_menus > 0) {
        for ($count = 0; $count < $num_menus; $count++) {
            $row = mysqli_fetch_assoc($menu_set);
            $user_menus[$count] = $row;
        }
        mysqli_free_result($menu_set);
        return $user_menus;
    } else {
        mysqli_free_result($menu_set);
        return null;
    }
}

function find_menuids($menus) {
    $num_menus = count($menus);
    $menuids = array();
    for ($count = 0; $count < $num_menus; $count++) {
        $menuids[] = $menus[$count]['menu_id'];
    }
    if (in_array(6, $menuids) && in_array(11, $menuids)) {
        return 'tasksrequests';
    } else if (in_array(6, $menuids)) {
        return 'requests';
    } else if (in_array(11, $menuids)) {
        return 'tasks';
    } else {
        return null;
    }
}

// get the row from the user_menus table
function does_this_exist($userid, $menu_id) {
    global $connection;
    $query = "SELECT * ";
    $query.="FROM user_menus ";
    $query.="WHERE user_id=$userid ";
    $query.="AND menu_id=$menu_id ";
    $query.="LIMIT 1 ";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    $row = mysqli_fetch_assoc($result_set);
    if (!empty($row)) {
        return $row;
    } else {
        return null;
    }
}

function find_submenus_for_menus($menu_id) {
    global $connection;
    $query = "SELECT  * FROM menus As m ";
    $query.="INNER JOIN menu_subs AS ms ON ms.menu_id = m.menu_id ";
    $query.="INNER JOIN submenus AS s ON ms.submenu_id = s.submenu_id ";
    $query.="WHERE m.menu_id = {$menu_id} ";
    $query.="ORDER BY s.submenu_name ASC ";
    $submenu_set = mysqli_query($connection, $query);
    confirm_query($submenu_set);
    $num_submenus = mysqli_num_rows($submenu_set);
    if ($num_submenus > 0) {
        for ($count = 0; $count < $num_submenus; $count++) {
            $row = mysqli_fetch_assoc($submenu_set);
            $submenus[$count] = $row;
        }
        mysqli_free_result($submenu_set);
        return $submenus;
    } else {
        return null;
    }
}

function display_submenus($menuid) {
    $submenus = find_submenus_for_menus($menuid);
    $num_submenus = count($submenus);
    if ($num_submenus > 0) {
        $output = "<ul class=\"nav nav-second-level\">";
        for ($count = 0; $count < $num_submenus; $count++) {
            $output.="<li>";
            $output.="<a href=\"";
            $output.=url_str($submenus[$count]["submenu_name"]);
            $output.=".php\">";
            $output.=htmlentities($submenus[$count]["submenu_name"]);
            $output.="</a> </li>";
        }
        $output.="</ul> ";
        return $output;
    } else {
        return null;
    }
}

function navigation($userid) {
    $menus = find_menus_for_user($userid);
    $num_menus = count($menus);
    $output = "";
    for ($count = 0; $count < $num_menus; $count++) {
        $output.="<li><a href=\"";
        $output.=url_str($menus[$count]["menu_name"]);
        $output.=".php\">";
        $output.=htmlentities($menus[$count]["menu_name"]);
        $output.="</a>";
        $output.= display_submenus($menus[$count]["menu_id"]);
        $output.= "</li>";
    }
    return $output;
}

function find_customer_by_search($search, $choice) {
    global $connection;
    $query = "SELECT * ";
    $query.="FROM customers WHERE ";
    $query.="{$choice} LIKE '%{$search}%' ";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    $num_customers = mysqli_num_rows($result_set);
    if ($num_customers > 0) {
        for ($count = 0; $count < $num_customers; $count++) {
            $row = mysqli_fetch_assoc($result_set);
            $customers[$count] = $row;
        }
        mysqli_free_result($result_set);
        return $customers;
    } else {
        mysqli_free_result($result_set);
        return null;
    }
}

function customer_connection($customer_id) {
    global $connection;
    $query = "SELECT con.connection_id,con.request_id, cus.customer_id ,cus.customer_code, cus.full_name, cus.location,r.technology,r.service,r.old_package,r.new_package,r.request_type, con.connection_date , con.status_id ";
    $query.="FROM connections AS con INNER JOIN requests AS r ON con.request_id=r.request_id ";
    $query.="INNER JOIN customers AS cus ON r.customer_id = cus.customer_id ";
    $query.="WHERE cus.customer_id={$customer_id} ";
    $query.="ORDER BY con.connection_date DESC LIMIT 1 ";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    $num_customers = mysqli_num_rows($result_set);
    if ($num_customers > 0) {
        $customer_connection = mysqli_fetch_assoc($result_set);
        if ($customer_connection['request_type'] === 'Terminate' && ((int) $customer_connection['status_id']) === 2) {
            return null;
        }
        mysqli_free_result($result_set);
        return $customer_connection;
    } else {
        mysqli_free_result($result_set);
        return null;
    }
}

function Make_button($customer_connection, $something, $request_type) {
    if ($request_type === 'upgrade') {
        $output = "<td><button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#";
        $output.=$customer_connection;
        $output.="\">Upgrade</button><div class=\"modal fade\" id=\"";
        $output.=$customer_connection;
        $output.="\" role=\"dialog\"><div class=\"modal-dialog\">";
        $output.="<div class=\"modal-content\"><div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button><h4 class=\"modal-title\">Upgrade Connection</h4></div><div class=\"modal-body\">";
        $output.="<div class=\"form-group\"><label>Current Package</label><input class=\"oldpack form-control\" value=\"$something\"></div>";
        $output.="<div class=\"form-group\"><label>New Package</label><input class=\"npack form-control\" placeholder=\"Enter Customer New Package\"><div class =\"np\"></div>";
        $output.="<div class=\"form-group\"><label for=\"comment\">Comment:</label><textarea class=\"form-control comm\"  rows=\"4\"></textarea></div>";
        $output.="</div></div><div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Cancel</button><button type=\"button\" class=\"submit btn btn-primary\">Upgrade</button></div></div></div></div></td></tr>";
        return $output;
    } else
    if ($request_type === 'relocation') {
        $output = "<td><button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#";
        $output.=$customer_connection;
        $output.="\">Relocate</button><div class=\"modal fade\" id=\"";
        $output.=$customer_connection;
        $output.="\" role=\"dialog\"><div class=\"modal-dialog\">";
        $output.="<div class=\"modal-content\"><div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button><h4 class=\"modal-title\">Relocate Connection</h4></div><div class=\"modal-body\">";
        $output.="<div class=\"form-group\"><label>Current Location</label><input class=\"oldloc form-control\" value=\"$something\"></div>";
        $output.="<div class=\"form-group\"><label>New Location</label><input class=\"nloc form-control\" placeholder=\"Enter Customer New Location\"><div class =\"nl\"></div>";
        $output.="<div class=\"form-group\"><label for=\"comment\">Comment:</label><textarea class=\"form-control comm\"  rows=\"4\"></textarea></div>";
        $output.="</div></div><div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Cancel</button><button type=\"button\" class=\"submit btn btn-primary\">Relocate</button></div></div></div></div></td></tr>";
        return $output;
    } else if ($request_type === 'terminate') {
        $output = "<td><button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#";
        $output.=$customer_connection;
        $output.="\">Terminate</button><div class=\"modal fade\" id=\"";
        $output.=$customer_connection;
        $output.="\" role=\"dialog\"><div class=\"modal-dialog\">";
        $output.="<div class=\"modal-content\"><div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button><h4 class=\"modal-title\">Terminate Connection</h4></div><div class=\"modal-body\"><p>Are you sure you want to terminate this connection?</p>";
        $output.="<div class=\"form-group\"><label for=\"comment\">Comment:</label><textarea class=\"form-control comm\"  rows=\"4\"></textarea></div>";
        $output.="</div><div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Cancel</button><button type=\"button\" class=\"submit btn btn-primary\">Terminate</button></div></div></div></div></td></tr>";
        return $output;
    }
}

function find_current_connection($customer_id, $request_type) {
    $customer_connection = customer_connection($customer_id);
    $num = count($customer_connection);
    if ($num > 0) {
        $output = "<tr id=\"" . $customer_connection['connection_id'] . '_' . $customer_connection['request_id'] . '_' . $customer_connection['customer_id'] . "\">";
        $output.="<td>" . $customer_connection['customer_code'] . "</td>";
        $output.="<td>" . $customer_connection['full_name'] . "</td>";
        $output.="<td>" . $customer_connection['location'] . "</td>";
        $output.="<td>" . $customer_connection['technology'] . "</td>";
        $output.="<td>" . $customer_connection['service'] . "</td>";
        $output.="<td>" . $customer_connection['old_package'] . "</td>";
        $output.="<td>" . $customer_connection['new_package'] . "</td>";
        $output.="<td>" . $customer_connection['request_type'] . "</td>";
        $output.="<td>" . $customer_connection['connection_date'] . "</td>";
        if ($request_type === 'upgrade') {
            $output.=Make_button($customer_connection['connection_id'], $customer_connection['new_package'], $request_type);
        } else
        if ($request_type === 'relocation') {
            $output.=Make_button($customer_connection['connection_id'], $customer_connection['location'], $request_type);
        } else if ($request_type === 'terminate') {
            $output.=Make_button($customer_connection['connection_id'], null, $request_type);
        }
        return $output;
    } else {
        return null;
    }
}

function find_all_requests($default = false) {
    global $connection;
    $query = "SELECT * FROM customers AS c INNER JOIN requests AS r ON c.customer_id = r.customer_id  ";
    if ($default === true) {
        $query.="WHERE r.request_marked_as = 'unseen'  ";
    } else if ($default === 'seen') {
        $query.="WHERE r.request_marked_as = 'seen' ";
    }
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    $num_requests = mysqli_num_rows($result_set);
    if ($num_requests > 0) {
        for ($count = 0; $count < $num_requests; $count++) {
            $row = mysqli_fetch_assoc($result_set);
            $requests[$count] = $row;
        }
        mysqli_free_result($result_set);
        return $requests;
    } else {
        return null;
    }
}

function find_user_task($userid, $start = null, $end = null) {
    global $connection;
    $query = "SELECT * FROM  assignments AS a INNER  JOIN requests AS r ON r.request_id = a.request_id WHERE a.data_manager_id = {$userid}  ";
    if ($start && $end !== null) {
        $query.="AND (assignment_created_on  BETWEEN '{$start}' AND '{$end}')  ";
    }
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    $num_assignments = mysqli_num_rows($result_set);
    if ($num_assignments > 0) {
        for ($count = 0; $count < $num_assignments; $count++) {
            $row = mysqli_fetch_assoc($result_set);
            $assignments[$count] = $row;
        }
        mysqli_free_result($result_set);
        return $assignments;
    } else {
        mysqli_free_result($result_set);
        return null;
    }
}

function find_user_assignments($userid, $start, $end) {
    global $connection;
    $query = "SELECT * FROM  assignments AS a INNER  JOIN requests AS r ON r.request_id = a.request_id WHERE a.eng_manager_id = {$userid} AND (assignment_created_on  BETWEEN '{$start}' AND '{$end}')  ";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    $num_assignments = mysqli_num_rows($result_set);
    if ($num_assignments > 0) {
        for ($count = 0; $count < $num_assignments; $count++) {
            $row = mysqli_fetch_assoc($result_set);
            $assignments[$count] = $row;
        }
        mysqli_free_result($result_set);
        return $assignments;
    } else {
        mysqli_free_result($result_set);
        return null;
    }
}

function find_all_assignments($datamanager_id, $default = false) {
    global $connection;
    $query = "SELECT * FROM customers AS c INNER JOIN requests AS r ON c.customer_id = r.customer_id INNER JOIN assignments AS a ON r.request_id = a.request_id WHERE a.data_manager_id = {$datamanager_id} ";
    if ($default === true) {
        $query.="AND assignment_marked_as = 'unseen' ";
    } else if ($default === 'seen') {
        $query.="AND (assignment_marked_as = 'seen' OR assignment_marked_as = 'in progress' OR assignment_marked_as = 'pending') ";
    }
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    $num_assignments = mysqli_num_rows($result_set);
    if ($num_assignments > 0) {
        for ($count = 0; $count < $num_assignments; $count++) {
            $row = mysqli_fetch_assoc($result_set);
            $assignments[$count] = $row;
        }
        mysqli_free_result($result_set);
        return $assignments;
    } else {
        mysqli_free_result($result_set);
        return null;
    }
}

function find_all_connections($start, $end) {
    global $connection;
    $query = "SELECT *   ";
    $query.="FROM connections AS con INNER JOIN requests AS r ON con.request_id = r.request_id WHERE(connection_date BETWEEN '{$start}' AND '{$end}' ) ";
    $connection_set = mysqli_query($connection, $query);
    confirm_query($connection_set);
    $num_connections = mysqli_num_rows($connection_set);
    if ($num_connections > 0) {
        for ($count = 0; $count < $num_connections; $count++) {
            $row = mysqli_fetch_assoc($connection_set);
            $connections[$count] = $row;
        }
        mysqli_free_result($connection_set);
        return $connections;
    } else {
        mysqli_free_result($connection_set);
        return null;
    }
}

function previous_comments($assign_id) {
    $comments = find_comments_by_assignid($assign_id);
    $num_comments = count($comments);
    if ($num_comments > 0) {
        $output = "";
        for ($count = 0; $count < $num_comments; $count++) {
            $output.=($comments[$count]["comm"] !== "" ? "<option value=\"" . $comments[$count]["comm"] . " \">" . $comments[$count]["comment_date"] . "</option>" : "");
        }
        return $output;
    } else {

        return null;
    }
}

function task_table($seen_assignments) {
    $output = "<table class=\"table table-striped table-bordered table-hover\"><thead><tr><th>Customer</th><th>Location</th><th>Technology </th>
         <th>Service</th><th>Package</th><th>Request Type</th><th>Task</th><th>Engineer Manager Comment</th><th>Completion Period </th><th> Comment</th><th>Change Status</th><th> Action</th></tr></thead><tbody>";
    $num_assignment = count($seen_assignments);
    for ($count = 0; $count < $num_assignment; $count++) {
        $output.="<tr id =\"" . $seen_assignments[$count]["assign_id"] . '_' . $seen_assignments[$count]["request_id"] . "\">";
        $output.="<td>" . htmlentities($seen_assignments[$count]["full_name"]) . "</td>";
        $output.="<td>" . htmlentities($seen_assignments[$count]["location"]) . "</td>";
        $output.="<td>" . htmlentities($seen_assignments[$count]["technology"]) . "</td>";
        $output.="<td>" . htmlentities($seen_assignments[$count]["service"]) . "</td>";
        $output.="<td>" . htmlentities($seen_assignments[$count]["new_package"]) . "</td>";
        $output.="<td>" . htmlentities($seen_assignments[$count]["request_type"]) . "</td>";
        $output.="<td>" . htmlentities($seen_assignments[$count]["task"]) . "</td>";
        $output.="<td>" . ($seen_assignments[$count]["eng_manager_comment"] !== "" ? htmlentities($seen_assignments[$count]["eng_manager_comment"]) : "No Comment") . "</td>";
        $output.="<td>" . htmlentities($seen_assignments[$count]["completion_days"]) . "</td>";
        $output.="<td><label>Edit or enter new</label><input class=\"comm\" type=\"text\" list=\"" . $seen_assignments[$count]["assign_id"] . "\"/><datalist id=\"" . $seen_assignments[$count]["assign_id"] . "\" >" . previous_comments($seen_assignments[$count]["assign_id"]) . "</datalist></td>";
        $output.="<td><select class = \"change\" class = \"form-control\" name = \"engineer\"><option value = \"\"> Status--</option></select> <div class = \"status\"></div></td>";
        $output.="<td><button type = \"submit\" name = \"submit\" value = \"submit\">change </button> </td></tr>";
    }
    $output.="</tbody></table>";
    return $output;
}

function request_table($seen_requests) {
    $output = "<table class = \"table table-striped table-bordered table-hover \"><thead><tr><th>Customer</th><th>Location</th><th>Technology </th><th>Service </th>";
    $output.="<th>Package</th><th>Type </th><th>Sales Comment </th><th>Task</th><th>Assign To:</th><th>Completion Days:</th><th> Comment </th><th>Action</th></tr></thead><tbody>";
    $num_request = count($seen_requests);
    for ($count = 0; $count < $num_request; $count++) {
        $output.="<tr id=\"" . $seen_requests[$count]["request_id"] . "\"><td>" . htmlentities($seen_requests[$count]["full_name"]) . "</td>";
        $output.="<td>" . htmlentities($seen_requests[$count]["location"]) . " </td>";
        $output.="<td>" . htmlentities($seen_requests[$count]["technology"]) . "</td>";
        $output.="<td>" . htmlentities($seen_requests[$count]["service"]) . "</td>";
        $output.="<td>" . htmlentities($seen_requests[$count]["new_package"]) . "</td>";
        $output.="<td>" . htmlentities($seen_requests[$count]["request_type"]) . "</td>";
        $output.="<td>" . ($seen_requests[$count]["sales_eng_comment"] !== "" ? htmlentities($seen_requests[$count]["sales_eng_comment"]) : "No Comment") . "</td>";
        $output.="<td>" . htmlentities($seen_requests[$count]["task"]) . "</td>";
        $output.="<td><select class = \" assign\" name = \"engineer\"></select> <div class = \"eng\"></div></td>";
        $output.="<td><input class = \"days\" name = \"days\" placeholder = \"Enter completion days\"><div class = \"day\"> </div></td>";
        $output.="<td><textarea class = \"form-control\" rows = \"4\" name = \"comm\"></textarea></td>";
        $output.="<td> <button type = \"submit\" name = \"submit\" value = \"submit\">Assign </button> </td>";
        $output.="</tr>";
    }
    $output.="</tbody></table>";
    return $output;
}

function return_table($array) {
    $num_array = count($array);
    $output = "<table class = \"table table-striped table-bordered table-hover\"><thead>";
    for ($count = 0; $count < $num_array; $count++) {
        $output.="<tr>";
        foreach ($array[$count] as $value) {
            $output.="<td>$value</td>";
        }
        if ($count === 0) {
            $output.= "</tr></thead><tbody>";
        } else {
            $output.="</tr>";
        }
    }
    $output.= "</tbody></table><a ";
//$output.="href=\"excel_export.php?task_array=" . implode(',', $array[0]) . "\" ";
    $output.="id = \"export\" type=\"button\" class=\"btn btn-primary\">Export To CSV <input type=\"hidden\" id=\"headers\" value=\"\"/></a>";
    return $output;
}

function general_report($report_array) {
    if ($report_array !== null) {
        return return_table($report_array);
    } else {
        return null;
    }
}

function report_array($connections, $num_connections) {
    if ($num_connections > 0) {
        $result = array();
        $report_array["activity"] = array("Activity", "Completed");
        for ($count = 0; $count < $num_connections; $count++) {
            $num_completed = find_connections_by_request_type($connections, $num_connections, $connections[$count]["request_type"]);
            $report_array[$connections[$count]["request_type"]] = array($connections[$count]["request_type"], $num_completed);
        }
        foreach ($report_array as $value) {
            $result[] = $value;
        }
        return $result;
    } else {
        return null;
    }
}

// generates array of the task report table
function task_array($assignments, $num_assignments) {
    if ($num_assignments > 0) {
        $result = array();
        $task_array["activity"] = array("Activity", "Pending", "In progress", "Completed");
        for ($count = 0; $count < $num_assignments; $count++) {
            if (($assignments[$count]["request_type"] === "New Connection" || $assignments[$count]["request_type"] === "Relocate") && $assignments[$count]["assigned_task"] === "Site survey") {
                $assignments[$count]["request_type"] = $assignments[$count]["assigned_task"];
            }
            $num_pending = find_task_by_request_type($assignments, $num_assignments, $assignments[$count]["request_type"], 'pending');
            $num_progress = find_task_by_request_type($assignments, $num_assignments, $assignments[$count]["request_type"], 'in progress');
            $num_completed = find_task_by_request_type($assignments, $num_assignments, $assignments[$count]["request_type"], 'completed');
            $task_array[$assignments[$count]["request_type"]] = array($assignments[$count]["request_type"], $num_pending, $num_progress, $num_completed);
        }
        foreach ($task_array as $value) {
            $result[] = $value;
        }
        return $result;
    } else {
        return null;
    }
}

function task_report($task_array) {
    if ($task_array !== null) {
        return return_table($task_array);
    } else {
        return null;
    }
}

function Update_requests($request_id = null, $default = false) {
    global $connection;
    $query = " UPDATE requests ";
    if ($default === true) {
        $query.=" SET request_marked_as = 'assigned' WHERE request_id = {$request_id} LIMIT 1 ";
    } else if ($default === 'installation') {
        $query.=" SET request_marked_as = 'unseen', task = 'Installation' WHERE request_id = {$request_id} LIMIT 1 ";
    } else if ($default === 'in progress') {
        $query.=" SET request_marked_as = 'in progress' WHERE request_id = {$request_id} LIMIT 1 ";
    } else if ($default === 'completed') {
        $query.=" SET request_marked_as = 'completed' WHERE request_id = {$request_id} ";
        $query.="LIMIT 1 ";
    } else if ($default === 'pending') {
        $query.=" SET request_marked_as = 'pending' WHERE request_id = {$request_id} ";
    } else {
        $query.=" SET request_marked_as = 'seen' WHERE request_marked_as = 'unseen' ";
    }
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    return $result_set;
}

function Update_assignments($id, $default = false) {
    global $connection;
    $query = " UPDATE assignments ";
    if ($default === true) {
        $query.=" SET assignment_marked_as = 'completed' WHERE assign_id = {$id} LIMIT 1 ";
    } else if ($default === 'in progress') {
        $query.=" SET assignment_marked_as = 'in progress' WHERE assign_id = {$id} LIMIT 1 ";
    } else if ($default === 'pending') {
        $query.=" SET assignment_marked_as = 'pending' WHERE assign_id = {$id} LIMIT 1 ";
    } else {
        $query.=" SET assignment_marked_as = 'seen' WHERE assignment_marked_as = 'unseen' AND data_manager_id = {$id} ";
    }
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    return $result_set;
}

function update_user_menus($userid, $menuid, $default = false) {
    global $connection;
    $query = " UPDATE user_menus ";
    if ($default) {
        $query.=" SET checked = 1 ";
    } else {
        $query.=" SET checked = 0 ";
    }
    $query.="WHERE user_id = $userid ";
    $query.="AND menu_id = {$menuid} ";
    $query.="LIMIT 1 ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function grant_menu($userid, $menuid) {
    global $connection;
    $query = " INSERT INTO user_menus ( ";
    $query.="user_id, menu_id, checked ";
    $query.=" ) VALUES ( ";
    $query.="{$userid}, {$menuid}, 1 ";
    $query.=") ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function find_request_by_id($request_id) {
    global $connection;
    $query = "SELECT * FROM requests WHERE request_id = {$request_id} ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $num_request = mysqli_num_rows($result);
    if ($num_request > 0) {
        $request = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $request;
    } else {
        mysqli_free_result($result);
        return null;
    }
}

function find_assignment_by_id($assignmentid) {
    global $connection;
    $query = "SELECT * FROM assignments WHERE assign_id = {$assignmentid} ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $num_assignment = mysqli_num_rows($result);
    if ($num_assignment > 0) {
        for ($count = 0; $count < $num_assignment; $count++) {
            $row = mysqli_fetch_assoc($result);
            $assignment[$count] = $row;
        }
        return $assignment;
    } else {
        return null;
    }
}

function find_requests_by_request_type($requests, $num_requests, $request_type) {
    $num_request_type = 0;
    for ($count = 0; $count < $num_requests; $count++) {
        if ($request_type === $requests[$count]["request_type"]) {
            ++$num_request_type;
        }
    }
    return $num_request_type;
}

function find_connections_by_request_type($connections, $num_connections, $request_type) {
    $num_connection_type = 0;
    for ($count = 0; $count < $num_connections; $count++) {
        $request = find_request_by_id($connections[$count]['request_id']);
        if ($request_type === $request["request_type"]) {
            ++$num_connection_type;
        }
    }
    return $num_connection_type;
}

function find_assignments_by_type($assignments, $num_assignments, $task, $request_type) {
    $num_assignment_type = 0;
    for ($count = 0; $count < $num_assignments; $count++) {
        if ($task === $assignments[$count]["task"] && $request_type === $assignments[$count]["request_type"]) {
            ++$num_assignment_type;
        }
    }
    return $num_assignment_type;
}

function find_task_by_request_type($assignments, $num_assignments, $request_type, $type) {
    $num_assignment_type = 0;
    for ($count = 0; $count < $num_assignments; $count++) {
        if ($request_type === $assignments[$count]["request_type"] && $type === $assignments[$count]["assignment_marked_as"]) {
            ++$num_assignment_type;
        }
    }
    return $num_assignment_type;
}

function find_default_request($requests, $num_requests) {
    $num_request_type = find_requests_by_request_type($requests, $num_requests, $requests[0]["request_type"]);
    $output = "<li><a href = \"view_requests.php\"><div>";
    $output.=htmlentities($requests[0]["request_type"]);
    $output.="<span class = \"pull-right text-muted small\">";
    $output.=($num_request_type === 1) ? $num_request_type . " Request " : $num_request_type . " Requests";
    $output.= "</span></div></a></li><li class = \"divider\"></li>";
    $result = array("output" => $output, "default_request_type" => $requests[0]["request_type"]);
    return $result;
}

function find_other_requests($requests, $num_requests, $default_request) {
    $default_request_type = $default_request;
    $output = "";
    for ($count = 0; $count < $num_requests; $count++) {
        if ($default_request === $requests[$count]["request_type"] || $default_request_type === $requests[$count]["request_type"]) {
            continue;
        }
        $num_request_type = find_requests_by_request_type($requests, $num_requests, $requests[$count]["request_type"]);
        $output.= "<li><a href = \"view_requests.php\"><div>";
        $output.=htmlentities($requests[$count]["request_type"]);
        $output.="<span class = \"pull-right text-muted small\">";
        $output.=($num_request_type === 1) ? $num_request_type . " Request" : $num_request_type . " Requests ";
        $output.= "</span></div></a></li><li class = \"divider\"></li>";
        $default_request_type = $requests[$count]["request_type"];
    }
    return $output;
}

function find_default_assignment($assignments, $num_assignments) {
    $num_assignment_type = find_assignments_by_type($assignments, $num_assignments, $assignments[0]["task"], $assignments[0]["request_type"]);
    $output = "<li><a href = \"view_tasks.php\"><div>";
    $output.=htmlentities($assignments[0]["task"]) . " ";
    $output.="For" . " ";
    $output.=htmlentities($assignments[0]["request_type"]);
    $output.="<span class = \"pull-right text-muted small\">";
    $output.=($num_assignment_type === 1) ? $num_assignment_type . " Task" : $num_assignment_type . " Tasks ";
    $output.= "</span></div></a></li><li class = \"divider\"></li>";
    $result = array("output" => $output, "default_request_type" => $assignments[0]["request_type"], "default_task_type" => $assignments[0]["task"]);
    return $result;
}

function find_other_assignments($assignments, $num_assignments, $default_request, $default_task) {
    $default_task_type = $default_task;
    $default_request_type = $default_request;
    $output = "";
    for ($count = 0; $count < $num_assignments; $count++) {
        if (($default_task === $assignments[$count]["task"] && $default_request === $assignments[$count]["request_type"]) || ($default_request_type === $assignments[$count]["request_type"] && $default_task_type === $assignments[$count]["task"])) {
            continue;
        }
        $num_assignment_type = find_assignments_by_type($assignments, $num_assignments, $assignments[$count]["task"], $assignments[$count]["request_type"]);
        $output.= "<li><a href = \"view_tasks.php\"><div>";
        $output.=htmlentities($assignments[$count]["task"]) . " ";
        $output.="For" . " ";
        $output.=htmlentities($assignments[$count]["request_type"]);
        $output.="<span class = \"pull-right text-muted small\">";
        $output.=($num_assignment_type === 1) ? $num_assignment_type . " Task" : $num_assignment_type . " Tasks ";
        $output.= "</span></div></a></li><li class = \"divider\"></li>";
        $default_request_type = $assignments[$count]["request_type"];
        $default_task_type = $assignments[$count]["task"];
    }
    return $output;
}

function Return_notifications($notification, $default_something, $output) {
    if ($notification === 'requests') {
        $result = "<li class=\"dropdown \" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-envelope fa-fw\"></i><span id=\"requestmes\"></span></a><ul class=\"dropdown-menu dropdown-alerts\">";
        $result.=$default_something;
        $result.= $output;
        $result .= "<li><a class = \"text-center\" href = \"view_requests.php\"><strong>See All Requests</strong><i class = \"fa fa-angle-right\"></i></a></li></ul></li>";
        return $result;
    } else if ($notification === 'tasks') {
        $result = "<li class=\"dropdown \" ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-tasks fa-fw\"></i><span id=\"taskmes\"></span></a><ul class=\"dropdown-menu dropdown-alerts\">";
        $result.=$default_something;
        $result.= $output;
        $result.= "<li><a class = \"text-center\" href = \"view_tasks.php\"><strong>See All Tasks</strong><i class = \"fa fa-angle-right\"></i></a></li></ul></li>";
        return $result;
    } else {
        
    }
}

function request_notifications($requests, $num_requests) {
    if ($num_requests > 0) {
        $default_request = find_default_request($requests, $num_requests);
        $other_request = find_other_requests($requests, $num_requests, $default_request["default_request_type"]);
        $notifications = Return_notifications('requests', $default_request["output"], $other_request);
        return $notifications;
    } else {
        $result = "<li  class=\"dropdown \"><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-envelope fa-fw\"></i><span id=\"requestmes\"></span></a><ul class=\"dropdown-menu dropdown-alerts\"><li><div class = \"text-center\"><strong>NO New Request Yet!!</strong></div></li></ul></li>";
        return $result;
    }
}

function task_notifications($assignments, $num_assignments) {
    if ($num_assignments > 0) {
        $default_assignment = find_default_assignment($assignments, $num_assignments);
        $other_assignments = find_other_assignments($assignments, $num_assignments, $default_assignment["default_request_type"], $default_assignment["default_task_type"]);
        $notifications = Return_notifications('tasks', $default_assignment["output"], $other_assignments);
        return $notifications;
    } else {
        $result = "<li class=\"dropdown \" > <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><i class=\"fa fa-tasks fa-fw\"></i><span id=\"taskmes\"></span></a><ul class=\"dropdown-menu dropdown-alerts\">";
        $result.= "<li><div class = \"text-center\">";
        $result.="<strong>NO New Task Yet!!</strong>";
        $result.= "</div></li></ul></li>";
        return $result;
    }
}

function password_encrypt($password) {

    $hash_format = "$2y$10$"; // Tells PHP to use Blowfish with a "cost parameter" of 10
    $salt_length = 22; // Blowfish salts should be 22-characters or more
    $salt = generate_salt($salt_length);
    $format_and_salt = $hash_format . $salt;

    $hash = crypt($password, $format_and_salt);

    return $hash;
}

function getTotalCustomers() {
    $num = count(find_all_customers());
    ++$num; // add 1;

    $len = strlen($num);
    for ($i = $len; $i < 8; ++$i) {
        $num = '0' . $num;
    }
    return $num;
}

function generate_salt($length) {
// Not 100% unique, not 100% random, but good enough for a salt
// MD5 returns 32 characters
    $unique_random_string = md5(uniqid(mt_rand(), true));

// Valid characters for a salt are [a-zA-Z0-9./]
    $base64_string = base64_encode($unique_random_string);

// But not '+' which is valid in base64 encoding
    $modified_base64_string = str_replace('+', '.', $base64_string);

//Truncate string to the correct length
    $salt = substr($modified_base64_string, 0, $length);

    return $salt;
}

function password_check($password, $existing_hash) {
// existing hash contains format and salt at start
    $hash = crypt($password, $existing_hash);
    if ($hash === $existing_hash) {
        return true;
    } else {
        return false;
    }
}

function attempt_login($username, $password) {
    $user = find_user_by_username($username);
    if ($user !== null) {
// Admin was found.
        if ($password === $user["hashed_password"]) {
// password matches
            return $user;
        } else {
// password does not match
            return false;
        }
    } else {
// User not found.
        return false;
    }
}

function logged_in() {
    return isset($_SESSION["user_id"]);
}

function confirm_logged_in() {
    if (!logged_in()) {
        redirect_to("login.php");
    }
}
