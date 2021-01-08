<?php

ini_set("display_errors", true);

include_once('../content/userManager.php');
include_once('../content/userVerification.php');



$request = UKMNorge\OAuth2\Request::createFromGlobals();
$method = $request->server['REQUEST_METHOD'];
$arguments = $request->request;
$debug = true;

// Return the verification code (REMOVE IT: SEND IT VIA SMS !!!)
try{

    if($method === "GET") {
        http_response_code(200);
        echo json_encode(array("code" => UserVerification::startVerification()), JSON_UNESCAPED_UNICODE);
    }
    // Check if verification code is correct
    else if($method === "POST") {
        $code = $request->requestRequired('code');
        echo json_encode(array(
            "result" => UserVerification::verify($code),
            "left" => UserVerification::triesLeft()
        ));
    }
    // Method is not supported
    else {
        http_response_code(405);
    }
}catch(Exception $e) {
    http_response_code(403);
}