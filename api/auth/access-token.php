<?php
// Verify a token
ini_set("display_errors", true);

require_once('UKM/Autoloader.php');

use UKMNorge\OAuth2\ServerMain;

$server = ServerMain::getServer();
$request = OAuth2\Request::createFromGlobals();

echo 'Dette skulle vært en accessToken for '. var_export($_POST, true);
// // Handle a request to a resource and authenticate the access token
// if (!$server->verifyResourceRequest($request)) {
//     $server->getResponse()->send();
//     die;
// }
// echo json_encode(array('result' => true));


# ARGS:
# client_id: testclient
# client_secret : testpass

// Check the client credentials
// Check the request_token
// Get access_token by providing request_token

// return access_token

?>