<?php

use UKMNorge\OAuth2\Request;
use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\ID\UserVerification;


ini_set("display_errors", true);

include_once('../../autoload.php');

$request = Request::createFromGlobals();
$method = $request->server['REQUEST_METHOD'];
$arguments = $request->request;
$debug = true;

$storage = ServerMain::getStorage();
$userTelNr = $request->requestRequired('tel_nr');


if(!SessionManager::verifyTimeout('sms_forward_tel_nr') || !SessionManager::verifyTimeout('sms_forward_code')) {
    echo 'Ikke tilgjengelig (not found or timeout)';
    die;
}

if(!SessionManager::verify('sms_forward_tel_nr', $userTelNr, true)) {
    echo 'tel_nr er ikke gyldig!';
}

$generatedCode = SessionManager::getWithTimeout('sms_forward_tel_nr')['value'];
$generatedCode = SessionManager::getWithTimeout('sms_forward_code')['value'];

$storage->checkSMSforward($telNr, $generatedCode);