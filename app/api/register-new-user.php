<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once('../../autoload.php');

use Datetime;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\HandleAPICall;

$debug = true;

$call = new HandleAPICall(['tel_nr', 'first_name', 'last_name', 'birthday', 'password'], [], ['POST'], false);

$tel_nr = $call->getArgument('tel_nr');
$firstName = $call->getArgument('first_name');
$lastName = $call->getArgument('last_name');
$birthday = new DateTime($call->getArgument('birthday'));
$password = $call->getArgument('password');

try{
    $user = UserManager::registerNewUser($tel_nr, $password, $firstName, $lastName, $birthday);
    // The user is registered and logged in
    if($user === true) {
       $call->sendToClient(true);
    }
    // The user has not been registered
    $call->sendErrorToClient("Brukeren ble ikke registrert!", 403);
    
}catch(Exception $e) {
    $call->sendErrorToClient($e->getMessage(), 500);
}