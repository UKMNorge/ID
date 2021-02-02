<?php

require_once('autoload.php');

ini_set("display_errors", true);

use UKMNorge\OAuth2\SessionManager;


// SessionManager::setWithTimeout('zippo', 'Hello World!', 100);

var_dump(SessionManager::getWithTimeout('zippo'));
var_dump($_SERVER['REQUEST_TIME']);
echo "<br>";
var_dump(SessionManager::verify('zippo', 'Hello World!', true));
