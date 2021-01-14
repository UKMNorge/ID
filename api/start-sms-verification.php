<?php

use UKMNorge\Kommunikasjon\Mottaker;


ini_set("display_errors", true);

include_once('../content/userManager.php');
include_once('../content/userVerification.php');



$request = UKMNorge\OAuth2\Request::createFromGlobals();
$method = $request->server['REQUEST_METHOD'];
$debug = true;


// Return the verification code (REMOVE IT: SEND IT VIA SMS !!!)



// EKSEMPEL:
// try{
//     $engangskode = 'A8X';
//     $mobilnummer = '+4799999999';
//     $melding = 'Hei! Din engangskode er '. $engangskode;
//     SMS::setSystemId('UKMid', 0);
//     $sms = new SMS('UKMNorge');
//     $result = $sms->setMelding( $melding )->setMottaker( Mottaker::fraMobil( $mobilnummer ) )->send();
// }catch(Exception $e) {
//     echo $e->getMessage();
// }




try{
    $tel_nr = $request->requestRequired('tel_nr');
    http_response_code(200);
    echo json_encode(array("code" => UserVerification::startVerification($tel_nr)), JSON_UNESCAPED_UNICODE);
}catch(Exception $e) {
    http_response_code(403);
}