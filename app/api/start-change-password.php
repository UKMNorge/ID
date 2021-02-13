<?php

include_once('../../autoload.php');

ini_set("display_errors", true);

use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\Request;
use UKMNorge\OAuth2\HandleAPICall;
use Exception;

$request = Request::createFromGlobals();

$call = new HandleAPICall(['code', 'tel_nr'], [], ['POST'], false);

$code = $call->getArgument('code');
$telNrUser = $call->getArgument('tel_nr');

## NOTE: start-sms-verification must be called before calling this file.

$telNr = false;

try {
    // Returns tel_nr if the verification is successful
    $telNr = UserVerification::verify($telNrUser, $code, null, false);
}catch(Exception $e) {
    $call->sendErrorToClient($e->getMessage(), 500);
}

if($telNr) {
    // Set change password to active (note: timeout is defined at UserVerification class)
    UserVerification::setChangePasswordActive($telNr);

    $call->sendToClient(array(
        "result" => true,
        "msg" => '',
        "left" => UserVerification::triesLeft()
    ));
}
$call->sendToClient(array(
    "result" => false,
    "msg" => "Feil kode",
    "left" => UserVerification::triesLeft()
));