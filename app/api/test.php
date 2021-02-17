<?php

include_once('../../autoload.php');

ini_set("display_errors", true);

use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\IdentityProvider\Basic\User as IPUser;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\ID\SessionManager;


// var_dump(UserManager::getUserByAccessToken('EAACAQQSnnxwBAPBk1JC7DoP28QLk53ZBsw3f7UfwcKngpXjVfUXYyBptlDVb5YaPpY8PQFCPuXRxHNEfRr6HlIECp1EGFyYKUeKENZBURiNXZCANAqcp5QcRqzGuUPsz7o6jJz7zTo5MBiKNSptvZCphXzLL8DFXu22CnVZBZCZAgZDZD'));
// UserManager::registerNewUserProvider('46544444');


// $storage = ServerMain::getStorage();

// $ipUser = new IPUser('fbid12938458204395829485', 'KushtrimFB', 'AliuFB');

// // var_dump($storage->registerUserWithServiceProvider('46516256', 'Facebook', $ipUser, 'ACCESSTOKEN8258269829'));
// var_dump($storage->checkUserCredentialsWithSP('46516256', 'fbid12938458204395829485', 'Facebook', 'ACCESSTOKEN8258269829'));


