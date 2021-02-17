<?php

include_once('../../autoload.php');
use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\HandleAPICall;
use UKMNorge\OAuth2\ID\SessionManager;


ini_set("display_errors", true);

$call = new HandleAPICall(['tel_nr', 'code', 'password', 'provider'], [], ['POST'], false);

$telNr = $call->getArgument('tel_nr');
$code = $call->getArgument('code');
$password = $call->getArgument('password');
$provider = $call->getArgument('provider');


if($provider && $password == null) {
    $call->sendErrorToClient('Mangler passord!', 403);
}

// Check if verification code is correct
try{
    $telNr = UserVerification::verify($telNr, $code, $password, ($provider ? false : true));
    
    if($telNr != false && $provider) {
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
        'details' => $e->getCode(),
        "left" => UserVerification::triesLeft()
    ), 403);
}
