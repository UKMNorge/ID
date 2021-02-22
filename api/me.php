<?php

ini_set("display_errors", true);

require_once('../autoload.php');

use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\ServerMain as Server;
use UKMNorge\OAuth2\Request;
use UKMNorge\OAuth2\HandleAPICall;

$server = Server::getServer();
$request = Request::createFromGlobals();

$call = new HandleAPICall(['access_token'], [''], ['GET'], false);

$accessToken = $call->getArgument('access_token');

// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest($request)) {
    $server->getResponse()->send();
    die;
}
