<?php

use Exception;
use UKMNorge\OAuth2\ID\UserManager;

ini_set("display_errors", true);

include_once('../../autoload.php');

$debug = true;
// Check if verification code is correct
try {
    http_response_code(200);
    echo json_encode(array(
        "result" =>  UserManager::setVilkaarToAccepted()
    ));
    
} catch(Exception $e) {
    if($debug) echo $e->getMessage();
    http_response_code(403);
}
