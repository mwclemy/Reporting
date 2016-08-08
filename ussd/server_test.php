<?php require_once("../web/includes/session.php"); ?>
<?php require_once("../web/includes/db_connection.php"); ?>
<?php include("functions.php"); ?>
<?php

function task_management($params) {
    $input = $params[0]['USSDRequestString'];
    $resp = $params[0]['response'];
    $phone = $params[0]['MSISDN'];
    $user = find_user_by_phone($phone);
    $transaction = ($user !== null ? find_user_transaction($user["user_id"]) : null);
    $status = find_all_status('completed');
    $num_status = count($status);
    if ($transaction === null && "false" === $resp) {
        $response = main_menu($params, $user, $status, $num_status, $input);
    } else {
        $response = other_menus($transaction["level"], $params, $status, $transaction, $input, $user);
    }
    return $response;
}

function ussd_handler($method_name, $params, $app_data) {
    $response = "";
    if ((!$params[0]['MSISDN']) || (!$params[0]['TransactionId']) || (!$params[0]['TransactionTime']) || (!$params[0]['USSDServiceCode']) || (!$params[0]['USSDRequestString'])) {
        $response = array('faultCode' => 4001, 'faultString' => 'Missing mandatory parameter');
    } else {
        switch ($params[0]['USSDServiceCode']) {
            case "100":
                $response = task_management($params);
                break;
            default:
                $response = array('faultCode' => 4002, 'faultString' => 'Unknown service request: ' . $params[0]['USSDServiceCode']);
        }
    }
    return $response;
}

header('Content-Type: text/xml');

$xmlrpc_server = xmlrpc_server_create();

xmlrpc_server_register_method($xmlrpc_server, "handleUSSDRequest", "ussd_handler");
$request_xml = file_get_contents("php://input");
print xmlrpc_server_call_method($xmlrpc_server, $request_xml, '');
