<?php

include_once('../../autoload.php');
use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\HandleAPICall;

ini_set("display_errors", true);

$call = new HandleAPICall(['tel_nr', 'code', 'password'], [], ['POST'], false);

$telNr = $call->getArgument('tel_nr');
$code = $call->getArgument('code');
$password = $call->getArgument('password');

// Check if verification code is correct
try{
    $call->sendToClient(array(
        "result" => UserVerification::verify($telNr, $code, $password, true) != false,
        "left" => UserVerification::triesLeft()
    ));
}catch(Exception $e) {
    $call->sendErrorToClient(array(
        "result" => false,
        'details' => $e->getCode(),
        "left" => UserVerification::triesLeft()
    ), 403);
}
