<?php

require_once('UKM/Autoloader.php');

use Exception;

use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\User;
use UKMNorge\OAuth2\TempUser;

class APIManager {
    private $request = UKMNorge\OAuth2\Request::createFromGlobals();
    private $method = $request->server['REQUEST_METHOD'];
    private $args;
    private $debug = true;


    public function __construct(array $methods, array $requiredArgs, array $optionalArgs) {
        
    }

    private function initMethods() {

    }

    private function initRequiredArgs() {

    }

    private function initOptionalArgs() {

    }
    
}