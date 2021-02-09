<?php

use UKMNorge\OAuth2\Request;
use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\ID\UserVerification;


ini_set("display_errors", true);

include_once('../../autoload.php');

$request = Request::createFromGlobals();
$method = $request->server['REQUEST_METHOD'];
$debug = true;

$storage = ServerMain::getStorage();
$task = $request->query('task');


if(!SessionManager::verifyTimeout('sms_forward_tel_nr') || !SessionManager::verifyTimeout('sms_forward_code')) {
    echo json_encode(array(
        'result' => null,
        'error' => 'Ikke tilgjengelig (not found or timeout)'
    ));
    die;
}

$telNr = SessionManager::getWithTimeout('sms_forward_tel_nr')['value'];
$generatedCode = SessionManager::getWithTimeout('sms_forward_code')['value'];

$result = $storage->checkSMSforward($telNr, $generatedCode);

echo json_encode(array(
    "result" => $result
));

if($result == true) {
    // Activate password change
    if($task == 'forgotPassword') {
        UserVerification::setChangePasswordActive($telNr);
    }
    // Verify the user and login
    else if($task == 'verifyUser') {
        $password = $request->query('password');
        UserManager::setUserVerifyAndLogin($telNr, $password);
    }
}
