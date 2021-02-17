<?php

include_once('../../autoload.php');

use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\HandleAPICall;
use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\ID\UserVerification;


ini_set("display_errors", true);

// Hvis 'task' er 'verifyUser', så trenger man password argumentet
$call = new HandleAPICall(['task'], ['password'], ['GET'], false);

if(!SessionManager::verifyTimeout('sms_forward_tel_nr') || !SessionManager::verifyTimeout('sms_forward_code')) {
    $call->sendErrorToClient('Ikke tilgjengelig', 403);
}

$telNr = SessionManager::getWithTimeout('sms_forward_tel_nr')['value'];
$generatedCode = SessionManager::getWithTimeout('sms_forward_code')['value'];

$result = ServerMain::getStorage()->checkSMSforward($telNr, $generatedCode);

if($result == true) {
    $task = $call->getArgument('task');

    // Activate password change
    if($task == 'forgotPassword') {
        UserVerification::setChangePasswordActive($telNr);
    }
    // Verify the user and login
    else if($task == 'verifyUser') {
        $password = $call->getOptionalArgument('password');
        UserManager::setUserVerifyAndLogin($telNr, $password);
    }
    else if($task == 'providerNewUser') {
        
    }
}

$call->sendToClient($result);

