<?php //require_once("../web/includes/session.php");                        ?>
<?php require_once("../web/includes/db_connection.php"); ?>
<?php include("../web/includes/functions.php"); ?>
<?php

//function whoami_func($params) {
//    $response = "";
//    if (strlen($params[0]["MSISDN"]) < 7) {
//        $response = array('TransactionId' => $params[0]['TransactionId'],
//            'TransactionTime' => $params[0]['TransactionTime'],
//            'USSDResponseString' => 'Incorrect MSISDN length. Expecting at least 7 digits.');
//    } else {
//$user = find_user_by_phone($params[0]["MSISDN"]);
//        if ($user === null) {
//            $response = array('TransactionId' => $params[0] ['TransactionId'],
//                'TransactionTime' => $params[0] ['TransactionTime'],
//                'USSDResponseString' => 'You are not allowed to use this service. ');
//        } else {
//            $status = find_all_status();
//            $num_status = count($status);
//            $string = "\r\n";
//            for ($count = 0; $count < $num_status; $count++) {
//                $string .=$status[$count]["status_id"] . ".  " . $status[$count]["status_name"];
//                $string.="\r\n";
//            }
//            $response = array('TransactionId' => $params[0] ['TransactionId'],
//                'TransactionTime' => $params[0] ['TransactionTime'],
//                'USSDResponseString' => $string);
//            
//            }
//    }
//    return $response;
//}
//
//function ussd_handler($method_name, $params, $app_data) {
//    $response = "";
//    if ((!$params[0]['MSISDN']) || (!$params[0]['TransactionId']) || (!$params[0]['TransactionTime']) || (!$params[0]['USSDServiceCode'])) {
//        $response = array('faultCode' => 4001, 'faultString' => 'Missing mandatory parameter');
//    } else {
//        /*
//         * Marshall the request based on the service code
//         */
//        switch ($params[0]['USSDServiceCode']) {
//            case "100":
//                $response = whoami_func($params);
//                break;
//            default:
//                $response = array('faultCode' => 4002, 'faultString' => 'Unknown service request: ' . $params[0]['USSDServiceCode']);
//        }
//    }
//    return $response;
//}

$xmlrpc_server = xmlrpc_server_create();
xmlrpc_server_register_method($xmlrpc_server, "handleUSSDRequest", "ussd_handler");
$request_xml = $HTTP_RAW_POST_DATA;
$response = xmlrpc_server_call_method($xmlrpc_server, $request_xml, '');
print $response;
xmlrpc_server_destroy($xmlrpc_server);
