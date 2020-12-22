<?php

require_once('UKM/Autoloader.php');

ini_set("display_errors", true);

use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\User;
use UKMNorge\OAuth2\TempUser;

class UserManager {
    private static $storage;

    public function __construct() {
        static::$storage = ServerMain::getStorage();
    }
    
    // Registrer en ny bruker
    public static function registerNewUser(string $tel_nr, string $password, string $firstName, string $lastName) : User {
        $user = new TempUser($tel_nr, $firstName, $lastName);

        return static::$storage->createUser($user, $password);
    }


    // Check if session is active
    public static function isSessionActive() {
        return static::$storage->isUserLoggedin();
    }

    public static function userLogout() {
        if(!isset($_SESSION)) { 
            session_start(); 
        }   

        unset($_SESSION["valid"]);
        unset($_SESSION["timeout"]);
        unset($_SESSION["tel_nr"]);    
    }

    public static function userLogin(string $tel_nr, string $password) : bool {
        if(!isset($_SESSION)) { 
            session_start(); 
        }        
        
        try{
            // Logged in, save session data
            if(static::$storage->checkUserCredentials($tel_nr, $password)) {
                // create Session
                $_SESSION['valid'] = true;
                $_SESSION['timeout'] = time() + 38000;
                $_SESSION['tel_nr'] = $tel_nr;
                return true;
            }
            // The user is not logged in
            return false;
        }
        catch(Exception $e) {
            // The user has not been found
            return false;
        }
    }

    // Oppdater bruker info
    public static function updateUserInfo(string $tel_nr, string $firstName = null, string $lastName = null) {
        $user = new User($tel_nr);

        if($firstName) {
            $user->setFirstName($firstName);
        }
        if($lastName) {
            $user->setLastName($lastName);
        }

        $user->save();
    }

    public static function changePassword($tel_nr, string $password) : bool {
        $user = new User($tel_nr);
        return $user->changePassword($password);
    }

    public static function setVerifiedUser($tel_nr) : bool {
        $user = new User($tel_nr);
        return $user->setTelNrVerified();
    }
}

$userManager = new UserManager();

// // update user info
// try {
//     $userManager->updateUserInfo('qwgqwwgwwehwqeqwgqwgqw1wqwq', 'Tom');
// }
// catch(Exception $e) {
//     echo 'Message: ' . $e->getMessage();
// }

// // change user password
// try {
//     $userManager->changePassword('qwgqwwgwwehwqeqwgqwgqw1wqwq', 'hello123Hello');
// }
// catch(Exception $e) {
//     echo 'Message: ' . $e->getMessage();
// }

// // Verify user mobile number
// try {
//     $userManager->setVerifiedUser('46516256');
// }
// catch(Exception $e) {
//     echo 'Message: ' . $e->getMessage();
// }

// // Register new user
// try{
//     $user = $userManager->registerNewUser('+4711122444', 'hello', 'aqwg', 'bqwg');
//     print_r($user);
// }
// catch(Exception $e) {
//     echo 'Message: ' . $e->getMessage();
// }

// echo 'hello';
// echo $userManager->userLogin('+4747854120', '123') ? 'login OK!' : 'Login error!';
// var_dump($userManager->userLogin('+4711122444', 'hello'));
