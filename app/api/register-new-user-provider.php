<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once('../../autoload.php');

use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\HandleAPICall;

$debug = true;

$call = new HandleAPICall(['tel_nr'], [], ['POST'], false);

$tel_nr = $call->getArgument('tel_nr');

// ******
// Save number to session
// ******

$call->sendToClient(true);
// try{
//     $user = UserManager::registerNewUserProvider($tel_nr);
//     // The user is registered and logged in
//     if($user === true) {
//        $call->sendToClient(true);
//     }
//     // The user has not been registered
//     $call->sendErrorToClient("Brukeren ble ikke registrert!", 403);
    
// }catch(Exception $e) {
//     $call->sendErrorToClient($e->getMessage(), 500);
// }