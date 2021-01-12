<?php
// Verify a token
ini_set("display_errors", true);

require_once('UKM/Autoloader.php');

use UKMNorge\OAuth2\ServerMain;

$server = ServerMain::getServer();
$request = OAuth2\Request::createFromGlobals();


// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest($request)) {
    $server->getResponse()->send();
    die;
}
echo json_encode(array('result' => true));

?>