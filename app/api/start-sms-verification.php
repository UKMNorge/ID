<?php

use UKMNorge\Kommunikasjon\Mottaker;
use UKMNorge\Kommunikasjon\SMS;
use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\Request;

ini_set("display_errors", true);
include_once('../../autoload.php');

$telNr = null;

// The user is logged in, use te user's tel_nr
if(UserManager::isUserLoggedin()) {
    $telNr = UserManager::getLoggedinUser()->getTelNr();
}

$request = Request::createFromGlobals();
$debug = true;
$telNr = $telNr ? $telNr : $request->requestRequired('tel_nr');


try {
    // If user is logged in, fetch tel_nr from User otherwise require it from Request
    $engangskode = UserVerification::startVerification($telNr);
    
    $melding = 'Hei! Din engangskode er '. $engangskode;
    SMS::setSystemId('UKMid', 0);
    $sms = new SMS('UKMNorge');
    $result = $sms->setMelding( $melding )->setMottaker( Mottaker::fraMobil( $telNr ) )->send();
} catch(Exception $e) {
    echo $e->getMessage();
}