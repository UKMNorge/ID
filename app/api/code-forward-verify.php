<?php

ini_set("display_errors", true);

include_once('../content/userManager.php');
include_once('../content/userVerification.php');


$request = UKMNorge\OAuth2\Request::createFromGlobals();
$method = $request->server['REQUEST_METHOD'];
$arguments = $request->request;
$debug = true;

// Sjekk databasen for å se hvis koden er mottatt