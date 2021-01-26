<?php

use UKMNorge\Kommunikasjon\Mottaker;
use UKMNorge\Kommunikasjon\SMS;

ini_set("display_errors", true);

include_once('../content/userManager.php');
include_once('../content/userVerification.php');

$request = UKMNorge\OAuth2\Request::createFromGlobals();
$debug = true;

try {
    $mobilnummer = $request->requestRequired('tel_nr');
    $engangskode = UserVerification::startVerification($mobilnummer);
    
    $melding = 'Hei! Din engangskode er '. $engangskode;
    SMS::setSystemId('UKMid', 0);
    $sms = new SMS('UKMNorge');
    $result = $sms->setMelding( $melding )->setMottaker( Mottaker::fraMobil( $mobilnummer ) )->send();
} catch(Exception $e) {
    echo $e->getMessage();
}