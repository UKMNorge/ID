<?php
// Verify a token
ini_set("display_errors", true);

require_once('UKM/Autoloader.php');

use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\Request;

$server = ServerMain::getServer();
// $request = OAuth2\Request::createFromGlobals();
$request = Request::createFromGlobals();



// grant_type=authorization_code&code=YOUR_CODE


// $request = Oauth2\Request::createFromGlobals();
// $request->setParameter('grant_type','authorization_code');

$request->addRequestItem('grant_type', 'authorization_code');
$server->handleTokenRequest($request)->send();





// Check the client credentials
// Check the request_token
// Get access_token by providing request_token

// return access_token
?>

