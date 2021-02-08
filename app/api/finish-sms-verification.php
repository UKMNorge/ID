<?php

use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\Request;

ini_set("display_errors", true);

include_once('../../autoload.php');

$request = Request::createFromGlobals();
$method = $request->server['REQUEST_METHOD'];
$debug = true;

// Check if verification code is correct
if($method === "POST") {
    $telNr = $request->requestRequired('tel_nr');
    $code = $request->requestRequired('code');
    $password = $request->requestRequired('password');

    try{
        echo json_encode(array(
            "result" => UserVerification::verify($telNr, $code, $password, true) != false,
            "left" => UserVerification::triesLeft()
        ));
    }catch(Exception $e) {
        echo json_encode(array(
            "result" => false,
            'msg' => $e->getCode(),
            "left" => UserVerification::triesLeft()
        ));
    }
}
// Method is not supported
else {
    http_response_code(405);
}