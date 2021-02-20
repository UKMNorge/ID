<?php

include_once('../../autoload.php');
use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\HandleAPICall;
use UKMNorge\OAuth2\ID\SessionManager;


ini_set("display_errors", true);

$call = new HandleAPICall(['tel_nr', 'code', 'password', 'task'], [], ['POST'], false);

$telNr = $call->getArgument('tel_nr');
$code = $call->getArgument('code');
$password = $call->getArgument('password');
$task = $call->getArgument('task');


// Check if verification code is correct
try{
    $login = $task != 'provider'; // Login only if $task is not provider, otherwise just verify the code and return tel_nr
    $telNr = UserVerification::verify($telNr, $code, $password, $login);
    
    if($telNr != false && $task == 'provider') {
        // Login through provider by getting the password from verificationCode
        UserManager::registerNewUserProvider($telNr);
    }
    $call->sendToClient(array(
        "result" => $telNr != false,
        "left" => UserVerification::triesLeft()
    ));
}catch(Exception $e) {
    $call->sendErrorToClient(array(
        "result" => false,
        'details' => $e->getMessage(),
        "left" => UserVerification::triesLeft()
    ), 403);
}
