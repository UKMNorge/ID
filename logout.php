<?php

use UKMNorge\OAuth2\ID\UserManager;

include_once('autoload.php');
    
UserManager::userLogout();

header('Refresh: 1; URL = /login-or-register.php');
