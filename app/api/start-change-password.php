<?php

include_once('../../autoload.php');

ini_set("display_errors", true);

use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\Request;
use Exception;

$request = Request::createFromGlobals();
$code = $request->requestRequired('code');


## NOTE: start-sms-verification must be called before calling this file.

$telNr = false;


try {
    $telNr = UserVerification::verify($code, null, false);
}catch(Exception $e) {
    echo json_encode(array(
        "result" => false,
        "msg" => $e->getMessage(),
        "left" => UserVerification::triesLeft()
    ));
    die;
}


if($telNr) {
    // Set waiting time to 5 min for password change
    SessionManager::setWithTimeout('changeUserPassword', $telNr, 5*60);

    echo json_encode(array(
        "result" => true,
        "msg" => '',
        "left" => UserVerification::triesLeft()
    ));
    die;
}
else {
    echo json_encode(array(
        "result" => false,
        "msg" => "Feil kode",
        "left" => UserVerification::triesLeft()
    ));
}