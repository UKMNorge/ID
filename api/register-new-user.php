<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once('../content/userManager.php');

use Datetime;

// IMPORTANT
// $tel_nr = isset($_GET['tel_nr']) ? $_GET['tel_nr'] : die();
$request = UKMNorge\OAuth2\Request::createFromGlobals();
$method = $request->server['REQUEST_METHOD'];
$arguments = $request->request;
$debug = true;

// constructor? with method
try {
    $tel_nr = $request->requestRequired('tel_nr');
    $firstName = $request->requestRequired('first_name');
    $lastName = $request->requestRequired('last_name');
    $birthday = new DateTime($request->requestRequired('birthday'));
    $password = $request->requestRequired('password');
}catch(Exception $e) {
    http_response_code(400);
    if($debug) echo $e->getMessage();
    return;
}

// var_dump($request->request);

try{
    $user = UserManager::registerNewUser($tel_nr, $password, $firstName, $lastName, $birthday);
    var_dump($user);
}catch(Exception $e) {
    if($debug) echo $e->getMessage();
    http_response_code(403);
}

        // echo json_encode(array("result" => UserVerification::verify($code)));
    
// } catch(Exception $e) {
//     http_response_code(405);
//     echo json_encode(array("result" => false));
//     echo 'aa';
// }


// if(UserManager::userExists($tel_nr)){
//     http_response_code(200);
// }
  
// else{
//     http_response_code(200);
//     echo json_encode(array("result" => false));
// }
