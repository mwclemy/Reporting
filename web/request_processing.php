<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/validation_functions.php"); ?>
<?php

$userid = get_userid();
$request_type = filter_input(INPUT_GET, "request_type");
?> 
<?php

if (null !== filter_input(INPUT_POST, "submit") || (null !== filter_input(INPUT_POST, "customer_id") && null !== filter_input(INPUT_POST, "request_id"))) {

    switch ($request_type) {
        case 'New Connection' :

            // inputs for new connection
            $full_name = filter_input(INPUT_POST, "fname");
            $contact = filter_input(INPUT_POST, "contact");
            $location = filter_input(INPUT_POST, "location");
            $technology = filter_input(INPUT_POST, "tech");
            $service = filter_input(INPUT_POST, "service");
            $package = filter_input(INPUT_POST, "package");
            $sales_eng_comment = filter_input(INPUT_POST, "comm");
            $task = "Site survey";
            // validations 
            $required_fields = array("fname", "contact", "location");
            validate_presences($required_fields);
            $fields_with_exact_lengths = array("contact");
            if (empty($errors)) {
                $number = getTotalCustomers();
                $customer_code = 'CS' . $number;

                $query = "CALL Request_newconnection('{$full_name}','{$contact}','{$location}','{$customer_code}','{$request_type}','{$technology}', '{$service}','{$package}',$userid,'{$sales_eng_comment}','{$task}' ) ";
                $result = mysqli_query($connection, $query);
                confirm_query($result);
                if ($result) {
                    $_SESSION["message"] = "A request for a new connection has been made ";
                    redirect_to("main.php");
                } else {
                    
                }
            }
            break;

        case 'Upgrade' :
            // inputs for upgrade
            $connection_id = filter_input(INPUT_POST, "connection_id");
            $request_id = filter_input(INPUT_POST, "request_id");
            $request = find_request_by_id($request_id);
            $technology = $request["technology"];
            $service = $request["service"];
            $old_package = $request["new_package"];
            $customer_id = filter_input(INPUT_POST, "customer_id");
            $newpack = filter_input(INPUT_POST, "newpack");
            $sales_eng_comment = filter_input(INPUT_POST, "comm");
            $task = "Renew";
            // validations 
            $required_fields = array("newpack");
            validate_presences($required_fields);

            if (empty($errors)) {
                $query = "CALL Request_upgrade('{$request_type}','{$technology}', '{$service}','{$old_package}','{$newpack}','{$task}',$userid,{$customer_id},'{$sales_eng_comment}' ) ";
                $result = mysqli_query($connection, $query);
                confirm_query($result);
                if ($result) {
                    $_SESSION["message"] = "A request for an Upgrade has been made ";
                    echo json_encode(true);
                } else {
                    
                }
            }
            break;
        case 'Relocate':
            // inputs for Relocation
            $connection_id = filter_input(INPUT_POST, "connection_id");
            $request_id = filter_input(INPUT_POST, "request_id");
            $request = find_request_by_id($request_id);
            $technology = $request["technology"];
            $service = $request["service"];
            $old_package = $request["old_package"];
            $customer_id = filter_input(INPUT_POST, "customer_id");
            $newpack = $request["new_package"];
            $sales_eng_comment = filter_input(INPUT_POST, "comm");
            $task = "Site survey";
            // validations 
            $required_fields = array("newloc");
            validate_presences($required_fields);

            if (empty($errors)) {
                $query = "CALL Request_upgrade('{$request_type}','{$technology}', '{$service}','{$old_package}','{$newpack}','{$task}',$userid,{$customer_id},'{$sales_eng_comment}' ) ";
                $result = mysqli_query($connection, $query);
                confirm_query($result);
                if ($result) {
                    $_SESSION["message"] = "A request for a  Relocation has been made ";
                    echo json_encode(true);
                } else {
                    
                }
            }
            break;
        case 'Terminate':
            // inputs for Termination
            $connection_id = filter_input(INPUT_POST, "connection_id");
            $request_id = filter_input(INPUT_POST, "request_id");
            $request = find_request_by_id($request_id);
            $technology = $request["technology"];
            $service = $request["service"];
            $old_package = $request["old_package"];
            $customer_id = filter_input(INPUT_POST, "customer_id");
            $newpack = $request["new_package"];
            $sales_eng_comment = filter_input(INPUT_POST, "comm");
            $task = "Uninstallation";
            if (empty($errors)) {
                $query = "CALL Request_upgrade('{$request_type}','{$technology}', '{$service}','{$old_package}','{$newpack}','{$task}',$userid,{$customer_id},'{$sales_eng_comment}' ) ";
                $result = mysqli_query($connection, $query);
                confirm_query($result);
                if ($result) {
                    $_SESSION["message"] = "A request for a Termination has been made ";
                    echo json_encode(true);
                } else {
                    
                }
            }
            break;
    }
}
