<?php

include_once('../../autoload.php');

use UKMNorge\Kommunikasjon\Mottaker;
use UKMNorge\Kommunikasjon\SMS;
use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\HandleAPICall;

ini_set("display_errors", true);

$telNr = null;
$requiredArgs = [];

// The user is logged in, use te user's tel_nr
if(UserManager::isUserLoggedin()) {
    $telNr = UserManager::getLoggedinUser()->getTelNr();
}
else {
    // If the user is not logged in, so the tel_nr is required
    $requiredArgs = ['tel_nr'];
}

$call = new HandleAPICall($requiredArgs, [], ['POST'], false);

$telNr = $telNr ? $telNr : $call->getArgument('tel_nr');

try {
    $engangskode = UserVerification::startVerification($telNr);
    
    $melding = 'Hei! Din engangskode er '. $engangskode;
    SMS::setSystemId('UKMid', 0);
    $sms = new SMS('UKMNorge');
    $result = $sms->setMelding( $melding )->setMottaker( Mottaker::fraMobil( $telNr ) )->send();
} catch(Exception $e) {
    $call->sendErrorToClient($e->getMessage(), 500);
}