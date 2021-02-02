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
    $code = $request->requestRequired('code');
    $password = $request->requestRequired('password');

    echo json_encode(array(
        "result" => UserVerification::verify($code, $password, true),
        "left" => UserVerification::triesLeft()
    ));
}
// Method is not supported
else {
    http_response_code(405);
}