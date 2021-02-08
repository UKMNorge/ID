<?php

include_once('../../autoload.php');

use UKMNorge\OAuth2\Request;
use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\ID\UserVerification;


$debug = true;
ini_set("display_errors", true);

$request = Request::createFromGlobals();

$storage = ServerMain::getStorage();

$telNr = $request->requestRequired('tel_nr');
$generatedCode = UserVerification::generateVerificationCode();

SessionManager::setWithTimeout('sms_forward_tel_nr', $telNr, 5*60);
SessionManager::setWithTimeout('sms_forward_code', $generatedCode, 5*60);

$storage->addSMSForward($telNr, $generatedCode);





