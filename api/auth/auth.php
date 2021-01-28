<?php

// ADD ARGUMENTS state and return_to

ini_set("display_errors", true);
require_once('UKM/Autoloader.php');

use OAuth2\Response;
use UKMNorge\OAuth2\ServerMain;
header('Content-Type: application/json');


# THIS IS THE CALL FROM USER TO START THE AUTHORIZATION PROCESS
# 


$server = ServerMain::getServer();
$storage = ServerMain::getStorage();


print_r($storage->getClientDetails('testclient'));

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