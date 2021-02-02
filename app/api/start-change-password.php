<?php

include_once('../../autoload.php');

ini_set("display_errors", true);

use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\Request;


$request = Request::createFromGlobals();
$code = $request->requestRequired('code');


## NOTE: start-sms-verification must be called before calling this file.

$telNr = UserVerification::getVerificationTelNr();

if(UserVerification::verify($code, null, false)) {
    // Tel_nr used by user for verification

    // Set waiting time to 5 min for password change
    SessionManager::setWithTimeout('changeUserPassword', $telNr, 5*60);

    echo json_encode(array(
        "result" => true,
        "left" => UserVerification::triesLeft()
    ));
    die;
}

http_response_code(405);