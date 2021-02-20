<?php

include_once('../../autoload.php');

ini_set("display_errors", true);

use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\IdentityProvider\Basic\User as IPUser;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\OAuth2\ID\SessionManager;


$client = new Google\Client();
// $client->authenticate('4/0AY0e-g5GQRBgIEK3kJiy93wSvxaUulHvbcuq69DBecm5a2IE5NH2JgRHx4Z7fYbVlXytqg');
// $access_token = $client->getAccessToken();

$client->setApplicationName('People API PHP Quickstart');
// $client->setScopes(Google_Service_PeopleService::CONTACTS_READONLY);
$client->setAuthConfig('google-credentials.json');
$client->setAccessType('offline');
// $client->setPrompt('select_account consent');

// var_dump($client);

$authCode = '4/0AY0e-g55uCSeOnSuKhZSVBdJDKSTV4lz4ZyKEUqKg9lyH8IK0xZANfLdS19bo1HV8J2PWA';
$response = $client->fetchAccessTokenWithAuthCode($authCode);

echo '<br><br>';
var_dump($response['access_token']);


// var_dump(UserManager::getUserByAccessToken('EAACAQQSnnxwBAPBk1JC7DoP28QLk53ZBsw3f7UfwcKngpXjVfUXYyBptlDVb5YaPpY8PQFCPuXRxHNEfRr6HlIECp1EGFyYKUeKENZBURiNXZCANAqcp5QcRqzGuUPsz7o6jJz7zTo5MBiKNSptvZCphXzLL8DFXu22CnVZBZCZAgZDZD'));
// UserManager::registerNewUserProvider('46544444');


// $ipUser = new IPUser('fbid12938458204395829485', 'KushtrimFB', 'AliuFB');

// // var_dump($storage->registerUserWithServiceProvider('46516256', 'Facebook', $ipUser, 'ACCESSTOKEN8258269829'));
// var_dump($storage->checkUserCredentialsWithSP('46516256', 'fbid12938458204395829485', 'Facebook', 'ACCESSTOKEN8258269829'));


