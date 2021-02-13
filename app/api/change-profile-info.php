<?php

include_once('../../autoload.php');

use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\HandleAPICall;
use Exception;

ini_set("display_errors", true);

$call = new HandleAPICall(['first_name', 'last_name'], [], ['POST'], true);

$firstName = $call->getArgument('first_name');
$lastName = $call->getArgument('last_name');

$user = UserManager::getLoggedinUser();

try{
    $user->changeFirstName($firstName);
    $user->changeLastName($lastName);
    $call->sendToClient(true);
} catch(Exception $e) {
    $call->sendErrorToClient($e->getMessage(), 500);
}