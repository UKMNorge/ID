<?php

ini_set("display_errors", true);

include_once('../content/userManager.php');
include_once('../content/userVerification.php');

$request = UKMNorge\OAuth2\Request::createFromGlobals();
$method = $request->server['REQUEST_METHOD'];
$debug = true;

// Check if verification code is correct
if($method === "POST") {
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