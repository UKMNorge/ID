<?php

include_once('../../autoload.php');

ini_set("display_errors", true);

use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\ID\UserVerification;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\Request;


$request = Request::createFromGlobals();
$newPassword = $request->requestRequired('new_password');
$telNr = SessionManager::get('changeUserPassword')['value'];

// Verify that changeUserPassword is in time
if(SessionManager::verify('changeUserPassword', $telNr, true)) {
   

    // Password change and return
    echo json_encode(array(
        "result" => UserManager::changePassword($telNr, $newPassword),
    ));
    
    SessionManager::remove('changeUserPassword');
    die;
}

http_response_code(405);
