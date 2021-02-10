<?php

include_once('../../autoload.php');

use UKMNorge\OAuth2\Request;
use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\ID\UserManager;

$debug = true;
ini_set("display_errors", true);

$waitingTime = 1*60;

$request = Request::createFromGlobals();
$storage = ServerMain::getStorage();

$telNr = null;

// The user is logged in, use te user's tel_nr
if(UserManager::isUserLoggedin()) {
    $telNr = UserManager::getLoggedinUser()->getTelNr();
}

$telNr = $telNr ? $telNr : $request->requestRequired('tel_nr');
$generatedCode = UserVerification::generateVerificationCode();

SessionManager::setWithTimeout('sms_forward_tel_nr', $telNr, $waitingTime);
SessionManager::setWithTimeout('sms_forward_code', $generatedCode, $waitingTime);

$storage->addSMSForward($telNr, $generatedCode);

echo json_encode(array(
    "result" => true,
    "code" => $generatedCode
));



