<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once('../content/userManager.php');

// IMPORTANT
// $tel_nr = isset($_GET['tel_nr']) ? $_GET['tel_nr'] : die();

$request = OAuth2\Request::createFromGlobals();

$tel_nr = $request->request['tel_nr'];

$result = UserManager::parseTelNr($tel_nr);

if(UserManager::userExists($tel_nr)){
    http_response_code(200);
    echo json_encode(array("result" => true));
}
  
else{
    http_response_code(200);
    echo json_encode(array("result" => false));
}
