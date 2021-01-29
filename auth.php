<?php

// ADD ARGUMENTS state and return_to

ini_set("display_errors", true);
require_once('autoload.php');

use OAuth2\Response;
use UKMNorge\OAuth2\ServerMain;
header('Content-Type: application/json');


# THIS IS THE CALL FROM USER TO START THE AUTHORIZATION PROCESS
# 


$server = ServerMain::getServer();
$storage = ServerMain::getStorage();


//print_r($storage->getClientDetails('testclient'));

if( isset($_GET['redirect_uri']) && !empty($_GET['redirect_uri']) && isset($_GET['client_id']) && !empty($_GET['client_id'])) {
    $returnUrl = urldecode($_GET['redirect_uri']).'?code='. sha1(rand(1000,2000));
    header("Location: $returnUrl");
} else {
    echo 'Missing parameters';
}

// Handle a request for an OAuth2.0 Access Token and send the response to the client
// $request = UKMNorge\OAuth2\Request::createFromGlobals();

// // Legger til client_secret
// $request->addRequestItem('client_secret', 'testpass');


// $response = $server->handleTokenRequest($request);

// $returnTo = $request->requestRequired('return_to');
// $response->setParameter('returnTo', $returnTo);

// Oppretter og lagrer request_token i tabllen

// Returner request_token til brukeren





// $response->send();