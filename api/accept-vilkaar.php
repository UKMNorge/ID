<?php

use Exception;

ini_set("display_errors", true);

include_once('../content/userManager.php');

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
