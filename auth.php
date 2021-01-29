<?php

ini_set("display_errors", true);
require_once('UKM/Autoloader.php');

use UKMNorge\OAuth2\ServerMain;
// use \OAuth2\Request;
use UKMNorge\OAuth2\Request;
use \OAuth2\Response;


$server = ServerMain::getServer();

$request = Request::createFromGlobals();
$response = new Response();

// Sjekk hvis brukeren er logged inn


// bruk klassen Request 
$clientId = $request->getAllQueryParameters()['client_id']; // User requestRequired()...
$request->addRequestItem('response_type', 'code');

// validate the authorize request
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}
// display an authorization form
if (empty($_POST) && $clientId != 'delta') {
  exit('
<form method="post">
  <label>Do You Authorize TestClient?</label><br />
  <input type="submit" name="authorized" value="yes">
  <input type="submit" name="authorized" value="no">
</form>');
}

// print the authorization code if the user has authorized your client
$is_authorized = ($_POST['authorized'] === 'yes') || $clientId == 'delta';
$server->handleAuthorizeRequest($request, $response, $is_authorized, '1234');
if ($is_authorized) {
  // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
  $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);
  // exit("SUCCESS! Authorization Code: $code");
}

echo $response->send();


?>