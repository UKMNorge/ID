<?php
ini_set("display_errors", true);

require_once('UKM/Autoloader.php');

use UKMNorge\OAuth2\ServerMain;

$server = ServerMain::getServer();

// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $server->getResponse()->send();
    die;
}
echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));

?>