<?php

use Exception;

require_once('../../autoload.php');

use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\Request;

ini_set("display_errors", true);
$debug = true;

$request = Request::createFromGlobals();

$firstName = $request->requestRequired('first_name');
$lastName = $request->requestRequired('last_name');

$user = null;

// The user is NOT logged in, no access
if(!UserManager::isUserLoggedin()) {
    http_response_code(403);
    die;
}

$user = UserManager::getLoggedinUser();

try{
    $user->changeFirstName($firstName);
    $user->changeLastName($lastName);
    http_response_code(200);
} catch(Exception $e) {
    echo json_encode(array(
        "error" =>  true,
        "message" => $e->getMessage()
    ));
}