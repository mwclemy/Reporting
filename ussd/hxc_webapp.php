<?php

function whoami_func($params) {
    $response = "";
    if (strlen($params[0]["MSISDN"]) < 7) {
        $response = array('TransactionId' => $params[0]['TransactionId'],
            'TransactionTime' => $params[0]['TransactionTime'],
            'USSDResponseString' => 'Incorrect MSISDN length. Expecting at least 7 digits.');
    } else {
        $response = array('TransactionId' => $params[0] ['TransactionId'],
            'TransactionTime' => $params[0] ['TransactionTime'],
            'USSDResponseString' => 'Your mobile number is: ' . $params[0]['MSISDN']);
    }
    return $response;
}

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
