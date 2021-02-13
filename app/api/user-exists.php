<?php

include_once('../../autoload.php');

use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\HandleAPICall;

error_reporting(E_ALL);
ini_set("display_errors", 1);

$call = new HandleAPICall(['tel_nr'], [], ['GET'], false);
$tel_nr = $call->getArgument('tel_nr');

$result = UserManager::parseTelNr($tel_nr);

if(UserManager::userExistsByTelNr($tel_nr)){
    $call->sendToClient(true);
}
$call->sendToClient(false);
