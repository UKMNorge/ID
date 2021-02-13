<?php
include_once('../../autoload.php');

use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\HandleAPICall;
use Exception;

ini_set("display_errors", true);

// redirectId er et valgfritt argument som brukes for å redirecte brukeren til en Service Provider
$call = new HandleAPICall([], ['redirectId'], ['POST'], true);

$redirectId = $call->getOptionalArgument('redirectId');

// Hvis det redirectId har blitt sendt, hent redirect URI
$uri = $redirectId ? UserManager::redirectCallbackURI($redirectId, true) : null;

try {
    $call->sendToClient(array(
        "result" =>  UserManager::setVilkaarToAccepted($redirectId),
        "uri" => $uri
    ));
    
} catch(Exception $e) {
    $call->sendErrorToClient($e->getMessage(), 403);
}
