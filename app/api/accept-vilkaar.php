<?php

use Exception;

require_once('../../autoload.php');

use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\Request;


ini_set("display_errors", true);

include_once('../../autoload.php');

$debug = true;
// Check if verification code is correct

$request = Request::createFromGlobals();


$redirectId = $request->request['redirectId'];

$uri = null;

if($redirectId != null) {
    $uri = UserManager::redirectCallbackURI($redirectId, true);
}

try {
    http_response_code(200);
    echo json_encode(array(
        "result" =>  UserManager::setVilkaarToAccepted($redirectId),
        "uri" => $uri
    ));
    
} catch(Exception $e) {
    if($debug) echo $e->getMessage();
    http_response_code(403);
}
