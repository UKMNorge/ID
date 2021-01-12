<?php

// ADD ARGUMENTS state and return_to

ini_set("display_errors", true);
require_once('UKM/Autoloader.php');
use UKMNorge\OAuth2\ServerMain;

$server = ServerMain::getServer();

// Handle a request for an OAuth2.0 Access Token and send the response to the client
$request = OAuth2\Request::createFromGlobals();

$response = $server->handleTokenRequest($request);
$response->send();

?>

