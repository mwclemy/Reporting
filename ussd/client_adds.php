<?php

//Using the XML-RPC extension to format the XML package
$service_url = "http://localhost/Reporting/ussd/server_add.php";
$method = "handleUSSDRequest";
$request = xmlrpc_encode_request($method, array(array("TransactionId" => "00001", "USSDServiceCode" => "100", "TransactionTime" => "20060723T14:08:55", "a" => "c", "b" => 6)));
$req = curl_init($service_url);

// Using the cURL extension to send it off,  first creating a custom header block
$headers = array();
array_push($headers, "Content-Type: text/xml");
array_push($headers, "Content-Length: " . strlen($request));
array_push($headers, "\r\n");

//URL to post to
curl_setopt($req, CURLOPT_URL, $service_url);

//Setting options for a secure SSL based xmlrpc server
curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($req, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($req, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($req, CURLOPT_HTTPHEADER, $headers);
curl_setopt($req, CURLOPT_POSTFIELDS, $request);

//Finally run
$response = curl_exec($req);

//Close the cURL connection
curl_close($req);

//Decoding the response to be displayed
$result = xmlrpc_decode($response);
echo($result["USSDResponseString"]);

