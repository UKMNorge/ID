<?php

// ADD ARGUMENTS state and return_to

ini_set("display_errors", true);
require_once('UKM/Autoloader.php');
include_once('../content/ClientManager.php');


use OAuth2\Response;
use UKMNorge\OAuth2\ServerMain;
header('Content-Type: application/json');



# THIS IS THE CALL FROM USER TO START THE AUTHORIZATION PROCESS
# 

$server = ServerMain::getServer();
$storage = ServerMain::getStorage();

$client = ClientManager::getClient('testClient');

// Check if the client exists
if(!$client) {
    http_response_code(403);
    die;
}

// Request
$request = UKMNorge\OAuth2\Request::createFromGlobals();

// Arguments from request
$clientId = $request->requestRequired('client_id');
$returnTo = $request->requestRequired('return_to');

// Legger til client_secret
$request->addRequestItem('client_secret', ClientManager::getClientSecret($clientId));
$response = $server->handleTokenRequest($request);

// Get access_token
$accessToken = $response->getParameter('access_token');
// Get request_token
$requestToken = $storage->getAccessToken($accessToken)['request_token'];

// Return request_token
var_dump($requestToken);



