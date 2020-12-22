<?php

ini_set("display_errors", true);

// session_start();

// echo 'aa:';
// print_r(isset($_SESSION['tel_nr']));

// if (isset($_SESSION['tel_nr']) && $_SESSION['tel_nr'] == true) {
//     echo "Welcome to the member's area, " . $_SESSION['tel_nr'] . "!";
// } else {
//     echo "You are not logged in!";
// }

require_once('UKM/Autoloader.php');

use UKMNorge\OAuth2\ServerMain;

$server = ServerMain::getServer();

// Handle a request for an OAuth2.0 Access Token and send the response to the client
$request = OAuth2\Request::createFromGlobals();

// print_r($request);

$response = $server->handleTokenRequest($request);
$response->send();

?>

