<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/validation_functions.php"); ?>
<?php

if (null !== filter_input(INPUT_POST, "search") && null !== filter_input(INPUT_POST, "choice") && null !== filter_input(INPUT_POST, "request_type")) {
    $search = filter_input(INPUT_POST, "search", FILTER_SANITIZE_STRING);
    $choice = filter_input(INPUT_POST, "choice", FILTER_SANITIZE_STRING);
    $request_type = filter_input(INPUT_POST, "request_type", FILTER_SANITIZE_STRING);
    $customers = find_customer_by_search($search, $choice);
    if ($customers !== null) {
        $num_customers = count($customers);
// Make a table 
// the heading of the table
        $head = "<table class = \"table table-striped table-bordered table-hover\"><thead><tr>";
        $head.="<th>Customer Code</th><th>Full Name</th><th>Location</th><th>Technology </th><th>Service</th><th>Old Package</th><th>Current Package</th><th>Request Type </th><th>Connection Date</th><th>Action</th>";
        $head.="</tr></thead><tbody>";
// the body of the table
        $body = "";
        for ($count = 0; $count < $num_customers; $count++) {
            $body.= find_current_connection($customers[$count]['customer_id'], $request_type);
        }
        $footer = "</tbody></table>";
        if ($body === "") {
            echo json_encode(array("connections" => null));
        } else {
            $html = $head . $body . $footer;
            echo json_encode(array("connections" => $html));
        }
    } else {
        echo json_encode(array("connections" => false));
    }
} else if (null !== filter_input(INPUT_POST, "id")) {
    $data = filter_input(INPUT_POST, "id");
    switch ($data) {

        case "tech":
            $technology_set = find_all_technology();
            $technology_count = mysqli_num_rows($technology_set);
            for ($count = 0; $count < $technology_count; $count++) {
                $row = mysqli_fetch_assoc($technology_set);
                $technology[$count] = array("id" => $row["tech_id"], "name" => $row["tech_name"]);
            }
            echo json_encode(array("technology" => $technology));


            break;


        case "assign":
            $engineers = find_all_engineers();
            echo json_encode(array("engineers" => $engineers));
            break;

        case "service":

            $service_set = find_all_services();
            $service_count = mysqli_num_rows($service_set);
            for ($count = 0; $count < $service_count; $count++) {
                $row = mysqli_fetch_assoc($service_set);
                $services[$count] = array("id" => $row["service_id"], "name" => $row["service_name"]);
            }
echo json_encode(array("services" => $services));

            break;

        case "role":
            $role_set = find_all_roles();
            $role_count = mysqli_num_rows($role_set);
            for ($count = 0; $count < $role_count; $count++) {
                $row = mysqli_fetch_assoc($role_set);
                $roles[$count] = array("id" => $row["role_id"], "name" => $row["role_name"]);
            }
            echo json_encode(array("roles" => $roles));
            break;

        case "checkUsername":
            $username = filter_input(INPUT_POST, "username");
            $user = find_user_by_username($username);
            if (!empty($user)) {
                $message = "Username in use";
                echo json_encode($message);
            } else {
                echo json_encode(false);
            }
            break;
        case 'change':
            $status = find_all_status();
            echo json_encode(array("status" => $status));
            break;
        case 'customer':
            $fields = find_all_customer_fields();
            $keys = array();
            foreach ($fields as $value) {
                $keys[] = $value['COLUMN_NAME'];
            }
            echo json_encode(array("keys" => $keys));
            break;
        case 'export':
            $task_array = filter_input(INPUT_POST, "task_array", FILTER_SANITIZE_STRING);
            excel_export($task_array);
            break;
        default :
            break;
    }
} else if (null !== filter_input(INPUT_POST, "start") && null !== filter_input(INPUT_POST, "end") && null !== filter_input(INPUT_POST, "type")) {
    $start = filter_input(INPUT_POST, "start", FILTER_SANITIZE_STRING);
    $end = filter_input(INPUT_POST, "end", FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);
    $userid = filter_input(INPUT_POST, "user_id");
    switch ($type) {
        case 'general':
            $connections = find_all_connections($start, $end);
            $num_connections = count($connections);
            $report_array = report_array($connections, $num_connections);
            $report_table = general_report($report_array);
            if ($report_table !== null) {
                $headers = array("start" => $start, "end" => $end);
                echo json_encode(array("report" => $report_table, "headers" => $headers));
            } else {
                echo json_encode(array("report" => null));
            }
            break;
        case 'task':
            $assignments = find_user_task($userid, $start, $end);
            $num_assignments = count($assignments);
            $task_array = task_array($assignments, $num_assignments);
            $task_table = task_report($task_array);
            if ($task_table !== null) {
                $headers = array("user_id" => $userid, "start" => $start, "end" => $end);
                echo json_encode(array("task" => $task_table, "headers" => $headers));
            } else {
                echo json_encode(array("task" => null));
            }
            break;
        case 'request':
            $requests = find_user_assignments($userid, $start, $end);
            $num_requests = count($requests);
            $task_array = task_array($requests, $num_requests);
            $task_table = task_report($task_array);
            if ($task_table !== null) {
                $headers = array("user_id" => $userid, "start" => $start, "end" => $end);
                echo json_encode(array("task" => $task_table, "headers" => $headers));
            } else {
                echo json_encode(array("task" => null));
            }
            break;
        default:
            break;
    }
} else if (null !== filter_input(INPUT_POST, "datamanagerid") && null !== filter_input(INPUT_POST, "request_id") && null !== filter_input(INPUT_POST, "days") && null !== filter_input(INPUT_POST, "eng_managerid")) {
    $eng_manager_id = (int) filter_input(INPUT_POST, "eng_managerid");
    $request_id = filter_input(INPUT_POST, "request_id");
    $datamanagerid = filter_input(INPUT_POST, "datamanagerid");
    $days = filter_input(INPUT_POST, "days");
    $eng_manager_comment = filter_input(INPUT_POST, "eng_manager_comment", FILTER_SANITIZE_STRING);
// validations
    $required_fields = array("days");
    validate_presences($required_fields);

// insert data into the Assignments table

    if (empty($errors)) {
// get task
        $request = find_request_by_id($request_id);
        $assigned_task = $request['task'];
        $query = "CALL Make_assignment( $days,$request_id,$datamanagerid,$eng_manager_id,'{$eng_manager_comment}', '{$assigned_task}' )  ";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        if ($result) {
// change request status  to assigned
            if (Update_requests($request_id, true)) {
                $message = "true";
                echo json_encode($message);
            } else {
                echo json_encode("false");
            }
        } else {
            echo json_encode("false");
        }
    } else {
        echo json_encode(array("errors", $errors));
    }
} else if (null !== filter_input(INPUT_POST, "assignmentid") && null !== filter_input(INPUT_POST, "statusid") && null !== filter_input(INPUT_POST, "request_id")) {
    $assignmentid = filter_input(INPUT_POST, "assignmentid");
    $status_id = (int) filter_input(INPUT_POST, "statusid");
    $data_manager_comment = filter_input(INPUT_POST, "data_manager_comment", FILTER_SANITIZE_STRING);
    $request_id = filter_input(INPUT_POST, "request_id");
    $assignment = find_assignment_by_id($assignmentid);
    $assigned_task = $assignment[0]['assigned_task'];
    if ($assigned_task === 'Site survey' && $status_id === 2) {
        // save the comment in the comments table.
        $query = "CALL Comment( $assignmentid,'{$data_manager_comment}' )  ";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        // update the assignment
        if (Update_assignments($assignmentid, true)) {
            // update the request
            if (Update_requests($request_id, 'installation')) {
                // insert into the site survey table
                $query = "CALL Site_survey( $assignmentid,'{$data_manager_comment}' )  ";
                $result = mysqli_query($connection, $query);
                confirm_query($result);
                if ($result) {
                    $message = "true";
                    echo json_encode($message);
                }
            }
        }
    } else if ($assigned_task === 'Installation' && $status_id === 2) {
        $query = "CALL Comment( $assignmentid,'{$data_manager_comment}' )  ";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        if (Update_assignments($assignmentid, true)) {
            if (Update_requests($request_id, 'completed')) {
// insert into the connection table
                $query = "CALL connection($assignmentid,'{$data_manager_comment}',$status_id,$request_id )  ";
                $result = mysqli_query($connection, $query);
                confirm_query($result);
                if ($result) {
                    $message = "true";
                    echo json_encode($message);
                }
            }
        }
    } else if ($assigned_task === 'Renew' && $status_id === 2) {
        $query = "CALL Comment($assignmentid,'{$data_manager_comment}' )  ";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        if (Update_assignments($assignmentid, true)) {
            if (Update_requests($request_id, 'completed')) {
// insert into the connection table
                $query = "CALL connection($assignmentid,'{$data_manager_comment}',$status_id,$request_id )  ";
                $result = mysqli_query($connection, $query);
                confirm_query($result);
                if ($result) {
                    $message = "true";
                    echo json_encode($message);
                }
            }
        }
    } else if ($assigned_task === 'Uninstallation' && $status_id === 2) {
        $query = "CALL Comment( $assignmentid,'{$data_manager_comment}' )  ";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        if (Update_assignments($assignmentid, true)) {
            if (Update_requests($request_id, 'completed')) {
// insert into the connection table
                $query = "CALL connection($assignmentid,'{$data_manager_comment}',$status_id,$request_id )  ";
                $result = mysqli_query($connection, $query);
                confirm_query($result);
                if ($result) {
                    $message = "true";
                    echo json_encode($message);
                }
            }
        }
    } else if ($status_id === 1) {
        $query = "CALL Comment( $assignmentid,'{$data_manager_comment}' )  ";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        if (Update_assignments($assignmentid, 'in progress')) {
            if (Update_requests($request_id, 'in progress')) {
                $message = "true";
                echo json_encode($message);
            }
        }
    } else if ($status_id === 3) {
        $query = "CALL Comment( $assignmentid,'{$data_manager_comment}' )  ";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        if (Update_assignments($assignmentid, 'pending')) {
            if (Update_requests($request_id, 'pending')) {
                $message = "true";
                echo json_encode($message);
            }
        }
    } else {
        
    }
} else if (null !== filter_input(INPUT_POST, "update") && null !== filter_input(INPUT_POST, "userid") && null !== filter_input(INPUT_POST, "menuid")) {
    $update = filter_input(INPUT_POST, "update", FILTER_SANITIZE_STRING);
    $userid = filter_input(INPUT_POST, "userid");
    $menuid = filter_input(INPUT_POST, "menuid");
    switch ($update) {
        case 'checked':
// check to see if the user has the menu
            $user_menu = does_this_exist($userid, $menuid);
            if ($user_menu !== null) {
                if (update_user_menus($userid, $menuid, true)) {
                    echo json_encode("true");
                } else {
                    echo json_encode("false");
                }
            } else {
// grant this user this menu
                if (grant_menu($userid, $menuid)) {
                    echo json_encode("true");
                } else {
                    echo json_encode("false");
                }
            }


            break;

        case 'unchecked':
// update the user_menus table
            if (update_user_menus($userid, $menuid)) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
            break;
    }
} else {
    
}
   

    










