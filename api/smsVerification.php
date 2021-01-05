<?php

ini_set("display_errors", true);

include_once('../content/userManager.php');
include_once('../content/userVerification.php');


$request = OAuth2\Request::createFromGlobals();
$method = $request->server['REQUEST_METHOD'];
$params = $request->getAllQueryParameters();

// Return the verification code
if($method === "GET") {
    http_response_code(200);
    echo json_encode(array("code" => UserVerification::startVerification()), JSON_UNESCAPED_UNICODE);
}
// Check if verification code is correct
else if($method === "POST") {
    $code = $request->headers['CODE'];
    echo json_encode(array("result" => UserVerification::verify($code)));
}
// Method is not supported
else {
    http_response_code(405);
}


// $tel_nr = isset($_GET['tel_nr']) ? $_GET['tel_nr'] : die();

// $tel_nr = UserManager::parseTelNr($tel_nr);

// if(UserManager::userExists($tel_nr)){
//     http_response_code(200);
//     echo json_encode(array("result" => true));
// }
  
// else{
//     http_response_code(404);
// }

?>