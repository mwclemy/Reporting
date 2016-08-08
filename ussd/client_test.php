<?php

if (null !== filter_input(INPUT_POST, "USSDRequestString")) {
    $input = filter_input(INPUT_POST, "USSDRequestString");
    $response = "true";
} else {
    $response = "false";
    $input = "#";
}
$request = xmlrpc_encode_request("handleUSSDRequest", array(array("MSISDN" => "0788312622", "TransactionId" => "00001", "USSDEncoding" => "GSM0338", "USSDServiceCode" => "100", "USSDRequestString" => $input, "response" => $response, "TransactionTime" => "20060723T14:08:55")));
$context = stream_context_create(array('http' => array(
        'method' => "POST",
        'header' => "Content-Type: text/xml\r\nUser-Agent: PHPRPC/1.0\r\n",
        'content' => $request
        )));
$server = 'http://localhost/Reporting/ussd/server_test.php';
$file = file_get_contents($server, false, $context);
$response = xmlrpc_decode($file);
if (isset($response["action"])) {
    if ($response["action"] === "request") {
        $result = $response["USSDResponseString"] . "<form method=\"post\" action=\"http://localhost/Reporting/ussd/client_test.php\"><input type=\"text\" name=\"USSDRequestString\" value=\"\"><input type=\"submit\" value=\"send\"></form>";
        echo $result;
    } else if ($response["action"] === "end") {
        echo $response["USSDResponseString"];
    } else {
        
    }
} else {
    print_r($response);
}



    