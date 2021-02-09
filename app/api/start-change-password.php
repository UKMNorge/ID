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
$telNrUser = $request->requestRequired('tel_nr');


## NOTE: start-sms-verification must be called before calling this file.


$telNr = false;


try {
    // Returns tel_nr if the verification is successful
    $telNr = UserVerification::verify($telNrUser, $code, null, false);
}catch(Exception $e) {
    echo json_encode(array(
        "result" => false,
        "msg" => $e->getMessage(),
        "left" => UserVerification::triesLeft()
    ));
    die;
}


if($telNr) {
    // Set change password to active (note: timeout is defined at UserVerification class)
    UserVerification::setChangePasswordActive($telNr);

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