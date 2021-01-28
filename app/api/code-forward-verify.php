<?php

use UKMNorge\OAuth2\Request;

ini_set("display_errors", true);

include_once('../../autoload.php');

$request = Request::createFromGlobals();
$method = $request->server['REQUEST_METHOD'];
$arguments = $request->request;
$debug = true;

// Sjekk databasen for å se hvis koden er mottatt