<?php

ini_set("display_errors", true);

require_once('../autoload.php');

use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\ServerMain as Server;
use UKMNorge\OAuth2\Request;

$server = Server::getServer();
$request = Request::createFromGlobals();

$accessToken = $request->query['access_token'];

// echo 'Hello I am bruker';


// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest($request)) {
    $server->getResponse()->send();
    die;
}

// Return user info (Object)
print_r(UserManager::getUserByAccessToken($accessToken, 'identify'));
