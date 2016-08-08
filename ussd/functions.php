<?php

function confirm_query($result_set) {
    global $connection;
    if (!$result_set) {
        die("database querry failed " . mysqli_error($connection));
    }
}

function find_all_status($status_name = null) {
    global $connection;
    $query = "SELECT *   ";
    $query.="FROM status ";
    if ($status_name !== null) {
        $query.="WHERE status_name <> '{$status_name}' ";
    }
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

function find_user_task($userid, $type) {
    global $connection;
    $query = "SELECT * FROM  assignments AS a INNER  JOIN requests AS r ON r.request_id = a.request_id WHERE a.data_manager_id = {$userid}  ";
    $query.="AND (assignment_marked_as=  '{$type}')  ";
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

function find_status_by_name($status_type) {
    global $connection;
    $query = "SELECT * FROM status WHERE status_name='{$status_type}' ";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    $row = mysqli_fetch_assoc($result_set);
    if ($row !== null) {
        mysqli_free_result($result_set);
        return $row;
    } else {
        mysqli_free_result($result_set);
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

function main_menu($params, $user, $status, $num_status, $input) {
    global $connection;
    if ($user === null) {
        $response = array('TransactionId' => $params[0] ['TransactionId'],
            'TransactionTime' => $params[0] ['TransactionTime'],
            'USSDResponseString' => 'You are not allowed to use this service. ');
    } else {
        $string = "Welcome to the Reporting Syswtem \n" . $user["fname"] . " " . $user["lname"] . " ,Choose:\n ";
        for ($count = 0; $count < $num_status; $count++) {
            $string .= $count + 1 . ".  " . ucfirst($status[$count]["status_name"]);
            $string.="\n";
        }
        $response = array('TransactionId' => $params[0] ['TransactionId'],
            'TransactionTime' => $params[0] ['TransactionTime'],
            'USSDResponseString' => nl2br($string), "action" => "request");
    }
    //set level to 1
    $level = 1;
    save_transaction($level, $input, $user["user_id"], $connection);
    return $response;
}

function find_user_transaction($user_id) {
    global $connection;
    $query = "SELECT * FROM ussd_transactions WHERE user_id={$user_id} ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $row = mysqli_fetch_assoc($result);
    return ($row !== null ? $row : null);
}

function find_customer_by_request($request_id) {
    global $connection;
    $query = "SELECT * FROM  customers AS c INNER  JOIN requests AS r ON r.customer_id = c.customer_id WHERE r.request_id = {$request_id}  ";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    $num_assignments = mysqli_num_rows($result_set);
    if ($num_assignments > 0) {
        $row = mysqli_fetch_assoc($result_set);
        mysqli_free_result($result_set);
        return $row;
    } else {
        mysqli_free_result($result_set);
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

function level_one_response($user_tasks, $num_task, $status_type, $params) {
    $string = ucfirst($status_type) . " Tasks \n";
    for ($count = 0; $count < $num_task; $count++) {
        $customer = find_customer_by_request($user_tasks[$count]["request_id"]);
        $string .=$count + 1 . ".  " . $user_tasks[$count]["assigned_task"] . " | " . $user_tasks[$count]["request_type"] . " | " . $customer["full_name"] . " | " . $customer["location"];
        $string.="\n";
    }
    $response = array('TransactionId' => $params[0] ['TransactionId'],
        'TransactionTime' => $params[0] ['TransactionTime'],
        'USSDResponseString' => nl2br($string), "action" => "request");

    return $response;
}

function level_two_response($params, $status_type) {
    $status = find_all_status($status_type);
    $num_status = count($status);
    $string = "You can change status to: \n";
    for ($count = 0; $count < $num_status; $count++) {
        $string .= $count + 1 . ".  " . ucfirst($status[$count]["status_name"]);
        $string.="\n";
    }
    $response = array('TransactionId' => $params[0] ['TransactionId'],
        'TransactionTime' => $params[0] ['TransactionTime'],
        'USSDResponseString' => nl2br($string), "action" => "request");

    return $response;
}

function update_transaction($transid, $level, $input, $connection) {
    $query = "CALL Update_transaction($transid,$level,'{$input}') ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
}

function clear_transaction($transid, $connection) {
    // clean transaction
    $query = "CALL Clear_transaction($transid) ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
}

function save_transaction($level, $input, $user_id, $connection) {
    $query = "CALL Save_transaction($level,'{$input}',$user_id) ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
}

function get_level_one($params, $status, $transaction, $input, $user) {
    global $connection;
    if (array_key_exists($input - 1, $status)) {
        // find user's tasks
        $user_tasks = find_user_task($user["user_id"], $status[$input - 1]["status_name"]);
        $num_task = count($user_tasks);
        if ($num_task > 0) {
            $response = level_one_response($user_tasks, $num_task, $status[$input - 1]["status_name"], $params);
            // increment level
            ++$transaction["level"];
// update the transaction
            update_transaction($transaction["transid"], $transaction["level"], $input, $connection);
        } else {
            $string = "Oops!! no \"" . ucfirst($status[$input - 1]["status_name"]) . "\" tasks \n" . "Assigned to you.";
            $response = array('TransactionId' => $params[0] ['TransactionId'], 'TransactionTime' => $params[0] ['TransactionTime'], 'USSDResponseString' => nl2br($string), "action" => "end");
            clear_transaction($transaction["transid"], $connection);
        }
    } else {
        $response = array('TransactionId' => $params[0] ['TransactionId'], 'TransactionTime' => $params[0] ['TransactionTime'], 'USSDResponseString' => "Not a valid input:" . $input, "action" => "end");
        clear_transaction($transaction["transid"], $connection);
    }
    return $response;
}

function get_level_two($params, $status, $transaction, $input, $user) {
    global $connection;
    $last_input = $transaction["last_input"];
    // $status is other status other than complete.
    $status_type = $status[$last_input - 1]["status_name"];
    $user_tasks = find_user_task($user["user_id"], $status_type);
    if (array_key_exists($input - 1, $user_tasks)) {
        $assign_id = $user_tasks[$input - 1]["assign_id"];
        $response = level_two_response($params, $status_type);
        // increment level
        ++$transaction["level"];
// update the transaction
        update_transaction($transaction["transid"], $transaction["level"], $assign_id, $connection);
    } else {
        $response = array('TransactionId' => $params[0] ['TransactionId'], 'TransactionTime' => $params[0] ['TransactionTime'], 'USSDResponseString' => "Not a valid input:" . $input, "action" => "end");
        clear_transaction($transaction["transid"], $connection);
    }
    return $response;
}

function get_level_three($params, $transaction, $input) {
    global $connection;
    $assign_id = $transaction["last_input"];
    $assignment = find_assignment_by_id($assign_id);
    // find all status except the one given in parantheses.
    $status = find_all_status($assignment[0]["assignment_marked_as"]);
    if (array_key_exists($input - 1, $status)) {
        $string = "Do you want to add comment? \n Press 1 for yes and # to exit";
        $response = array('TransactionId' => $params[0] ['TransactionId'], 'TransactionTime' => $params[0] ['TransactionTime'], 'USSDResponseString' => nl2br($string), "action" => "request");
        $last_input = $assign_id . "_" . $status[$input - 1]["status_name"];
        update_transaction($transaction["transid"], ++$transaction["level"], $last_input, $connection);
    } else {
        $response = array('TransactionId' => $params[0] ['TransactionId'], 'TransactionTime' => $params[0] ['TransactionTime'], 'USSDResponseString' => "Not a valid input:" . $input, "action" => "end");
        clear_transaction($transaction["transid"], $connection);
    }
    return $response;
}

function update_site_survey($assignmentid, $data_manager_comment, $request_id) {
    global $connection;
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
        }
    }
}

function update_installation($assignmentid, $data_manager_comment, $request_id, $status_id) {
    global $connection;
    $query = "CALL Comment( $assignmentid,'{$data_manager_comment}' )  ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    if (Update_assignments($assignmentid, true)) {
        if (Update_requests($request_id, 'completed')) {
// insert into the connection table
            $query = "CALL connection($assignmentid,'{$data_manager_comment}',$status_id,$request_id )  ";
            $result = mysqli_query($connection, $query);
            confirm_query($result);
        }
    }
}

function update_renew($assignmentid, $data_manager_comment, $request_id, $status_id) {
    global $connection;
    $query = "CALL Comment($assignmentid,'{$data_manager_comment}' )  ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    if (Update_assignments($assignmentid, true)) {
        if (Update_requests($request_id, 'completed')) {
// insert into the connection table
            $query = "CALL connection($assignmentid,'{$data_manager_comment}',$status_id,$request_id )  ";
            $result = mysqli_query($connection, $query);
            confirm_query($result);
        }
    }
}

function update_uninstallation($assignmentid, $data_manager_comment, $request_id, $status_id) {
    global $connection;
    $query = "CALL Comment( $assignmentid ,'{$data_manager_comment}' )  ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    if (Update_assignments($assignmentid, true)) {
        if (Update_requests($request_id, 'completed')) {
// insert into the connection table
            $query = "CALL connection($assignmentid,'{$data_manager_comment}',$status_id,$request_id )  ";
            $result = mysqli_query($connection, $query);
            confirm_query($result);
        }
    }
}

function update_inprogress($assignmentid, $request_id, $data_manager_comment) {
    global $connection;
    $query = "CALL Comment( $assignmentid,'{$data_manager_comment}' )  ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    if (Update_assignments($assignmentid, 'in progress')) {
        Update_requests($request_id, 'in progress');
    }
}

function update_pending($assignmentid, $request_id, $data_manager_comment) {
    global $connection;
    $query = "CALL Comment( $assignmentid,'{$data_manager_comment}' )  ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    if (Update_assignments($assignmentid, 'pending')) {
        Update_requests($request_id, 'pending');
    }
}

function update_task($assign_id, $assigned_task, $request_id, $status, $data_manager_comment, $transaction, $params) {
    global $connection;
    if ($assigned_task === 'Site survey' && (int) $status["status_id"] === 2) {
        update_site_survey($assign_id, $data_manager_comment, $request_id);
    } else if ($assigned_task === 'Installation' && (int) $status["status_id"] === 2) {
        update_installation($assign_id, $data_manager_comment, $request_id, (int) $status["status_id"]);
    } else if ($assigned_task === 'Renew' && $status["status_id"] === 2) {
        update_renew($assign_id, $data_manager_comment, $request_id, (int) $status["status_id"]);
    } else if ($assigned_task === 'Uninstallation' && $status["status_id"] === 2) {
        update_uninstallation($assign_id, $data_manager_comment, $request_id, (int) $status["status_id"]);
    } else if ((int) $status["status_id"] === 1) {
        update_inprogress($assign_id, $request_id, $data_manager_comment);
    } else if ((int) $status["status_id"] === 3) {
        update_pending($assign_id, $request_id, $data_manager_comment);
    } else {
        
    }
    $response = array('TransactionId' => $params[0] ['TransactionId'], 'TransactionTime' => $params[0] ['TransactionTime'], 'USSDResponseString' => "Your changes have been recorded.", "action" => "end");
    clear_transaction($transaction["transid"], $connection);
    return $response;
}

function get_level_four($params, $transaction, $input) {
    global $connection;
    $last_input = $transaction["last_input"];
    $lastinput = explode("_", $last_input);
    $assign_id = $lastinput[0];
    $status_type = $lastinput [1];
    $assignment = find_assignment_by_id($assign_id);
    $request_id = $assignment[0]["request_id"];
    $assigned_task = $assignment[0]["assigned_task"];
    $status = find_status_by_name($status_type);
    if ($input === "1") {
// the status was changed and the comment was added.
        update_transaction($assign_id, ++$transaction["level"], $last_input, $connection);
        $string = "Add comment \n";
        $response = array('TransactionId' => $params[0] ['TransactionId'], 'TransactionTime' => $params[0] ['TransactionTime'], 'USSDResponseString' => nl2br($string), "action" => "request");
    } else if ($input === "#") {
        // only the status was changed.
        $response = update_task($assign_id, $assigned_task, $request_id, $status, "", $transaction, $params);
    } else {
        $response = array('TransactionId' => $params[0] ['TransactionId'], 'TransactionTime' => $params[0] ['TransactionTime'], 'USSDResponseString' => "Not a valid input:" . $input, "action" => "end");
        clear_transaction($transaction["transid"], $connection);
    }
    return $response;
}

function get_level_five($params, $transaction, $input) {
    $last_input = $transaction["last_input"];
    $lastinput = explode("_", $last_input);
    $assign_id = $lastinput[0];
    $status_type = $lastinput [1];
    $assignment = find_assignment_by_id($assign_id);
    $request_id = $assignment[0]["request_id"];
    $assigned_task = $assignment[0]["assigned_task"];
    $status = find_status_by_name($status_type);
    $response = update_task($assign_id, $assigned_task, $request_id, $status, $input, $transaction, $params);
    return $response;
}

function other_menus($level, $params, $status, $transaction, $input, $user) {
    switch ($level) {
        case 1:
            $response = get_level_one($params, $status, $transaction, $input, $user);
            break;
        case 2:
            $response = get_level_two($params, $status, $transaction, $input, $user);
            break;
        case 3:
            $response = get_level_three($params, $transaction, $input);
            break;
        case 4:
            $response = get_level_four($params, $transaction, $input);
            break;
        case 5:
            $response = get_level_five($params, $transaction, $input);
            break;
        default :
            break;
    }
    return $response;
}
