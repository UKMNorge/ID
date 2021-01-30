<?php

ini_set("display_errors", true);

require_once('autoload.php');

use Entities\User;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\ServerMain;
// use \OAuth2\Request;
use UKMNorge\OAuth2\Request;
use \OAuth2\Response;


$server = ServerMain::getServer();

$request = Request::createFromGlobals();
$response = new Response();

$queryParams = $request->getAllQueryParameters();

// Sjekk hvis brukeren er logged inn eller brukeren har ikke godtatt vilkaar
if(!UserManager::isUserLoggedin() || !UserManager::getLoggedinUser()->isVilkaarAccepted()) {
  $uriId = UserManager::addCallbackURIToSession($queryParams['redirect_uri']);
  header('Location: /?redirectId=' . $uriId);
  die;
}

// Logged in user
$user = UserManager::getLoggedinUser();

// bruk klassen Request 
$clientId = $queryParams['client_id']; // Use requestRequired()...
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
$server->handleAuthorizeRequest($request, $response, $is_authorized, $user->getTelNr());
if ($is_authorized) {
  // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
  $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);
  // exit("SUCCESS! Authorization Code: $code");
}

echo $response->send();


?>
