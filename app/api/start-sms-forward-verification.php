<?php

include_once('../../autoload.php');

use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\HandleAPICall;

$debug = true;
ini_set("display_errors", true);

$waitingTime = 5*60;

$telNr = null;
$requiredArgs = [];

// The user is logged in, use te user's tel_nr
if(UserManager::isUserLoggedin()) {
    $telNr = UserManager::getLoggedinUser()->getTelNr();
}
else {
    $requiredArgs = ['tel_nr'];
}

$call = new HandleAPICall($requiredArgs, [], ['POST'], false);

$generatedCode = UserVerification::generateVerificationCode();
$telNr = $telNr ? $telNr : $call->getArgument('tel_nr');

SessionManager::setWithTimeout('sms_forward_tel_nr', $telNr, $waitingTime);
SessionManager::setWithTimeout('sms_forward_code', $generatedCode, $waitingTime);

ServerMain::getStorage()->addSMSForward($telNr, $generatedCode);

$call->sendToClient(array(
    "result" => true,
    "code" => $generatedCode
));



