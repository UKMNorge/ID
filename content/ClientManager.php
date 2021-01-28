<?php

ini_set("display_errors", true); //
ini_set('session.cookie_lifetime', 2592000); // 30 days

require_once('UKM/Autoloader.php');

// use Exception;
        
session_start();

use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\User;
use UKMNorge\OAuth2\TempUser;

class UserManager {
    private static $storage;

    public function __construct() {
        static::$storage = ServerMain::getStorage();
    }
    
    public function clientExists

}