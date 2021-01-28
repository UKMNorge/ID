<?php

namespace UKMNorge\OAuth2\ID;

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