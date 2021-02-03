<?php

include_once('../../autoload.php');

ini_set("display_errors", true);

use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\Request;
use Exception;


$request = Request::createFromGlobals();
$newPassword = $request->requestRequired('new_password');
$telNr = SessionManager::get('changeUserPassword')['value'];

// Verify that changeUserPassword is in time
if(SessionManager::verify('changeUserPassword', $telNr, true)) {
    $changePassword = false;
    $msg = null;

    try {
        $changePassword = UserManager::changePassword($telNr, $newPassword);
    }
    catch(Exception $e){
        $msg = $e->getMessage();
    }

    // Password change and return
    echo json_encode(array(
        "result" => $changePassword,
        'timeout' => false,
        "msg" => $msg
    ));
    
    SessionManager::remove('changeUserPassword');
    die;
}

echo json_encode(array(
    "result" => false,
    'timeout' => true,
    "msg" => 'Du har brukt lang tid for å verifisere deg, prøv igjen!'
));
