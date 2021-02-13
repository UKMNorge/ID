<?php

include_once('../../autoload.php');

ini_set("display_errors", true);

use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\HandleAPICall;
use Exception;


$call = new HandleAPICall(['new_password'], [], ['POST'], false);

$newPassword = $call->getArgument('new_password');
$telNr = SessionManager::get('changeUserPassword')['value'];

// Verify that changeUserPassword is in time
if(SessionManager::verify('changeUserPassword', $telNr, true)) {
    $changePassword = false;
    $msg = null;

    try {
        $changePassword = UserManager::changePassword($telNr, $newPassword);
    }
    catch(Exception $e){
        $msg = $e->getMessage();
    }

    SessionManager::remove('changeUserPassword');
    
    $call->sendToClient(array(
        "result" => $changePassword,
        'timeout' => false,
        'details' => $msg
        
    ), $msg == null ? 200 : 403);
    
}
$call->sendErrorToClient(array(
    "result" => false,
    'timeout' => true,
    "details" => 'Du har brukt lang tid for å verifisere deg, prøv igjen!'
), 403);


