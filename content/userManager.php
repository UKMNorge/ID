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
    
    // Registrer en ny bruker
    public static function registerNewUser(string $tel_nr, string $password, string $firstName, string $lastName, DateTime $birthday) : bool {  
        $user = new TempUser(static::parseTelNr($tel_nr), $firstName, $lastName, $birthday);
        $isUserCreated = static::$storage->createUser($user, $password);

        // If the user is created, login 
        if($isUserCreated === true) {
            return true;
        }
        return null;
    }
    
    public static function setUserVerifyAndLogin(string $tel_nr, string $password) {
        $res = static::$storage->setUserToVerified($tel_nr);

        if($res) {
            static::userLogin($tel_nr, $password);
        }
    }

    public static function setVilkaarToAccepted() : bool {
        if(static::isUserLoggedin()) {
            $user = static::getLoggedinUser();
            $user->setVilkaarToAccepted();
            return static::$storage->setVilkaarToAccepted($user);
        }

        throw new Exception("Brukeren er ikke logged inn derfor vilkaar kan ikke settes");
    }

    // Check if session is active
    public static function isUserLoggedin() {
        return static::$storage->isUserLoggedin();
    }

    public static function getLoggedinUser() {
        if(static::isUserLoggedin()) {
            return $_SESSION['user'];
        }
        throw new Exception('Brukeren er ikke logged inn');
    }

    public static function userExists($tel_nr) {
        return static::$storage->userExists($tel_nr);
    }

    public static function userLogout() {        
        // Unset all session variables
        $_SESSION = array();
        session_destroy();
    }

    public static function parseTelNr(string $tel_nr) : string {
        // Fjern +47 hvis det er lagt til
        if(substr($tel_nr, 0, 3-strlen($tel_nr)) == '+47') {
            $tel_nr = substr($tel_nr, 3);
        }
        return $tel_nr;
    }

    public static function userLogin(string $tel_nr, string $password) : bool {
        $tel_nr = static::parseTelNr($tel_nr);
        
        try{
            // Logged in, save session data
            if(static::$storage->checkUserCredentials($tel_nr, $password)) {
                // IMPORTANT: consider removing valid and tel_nr and using only User instance
                // create Session
                $_SESSION['valid'] = true;
                $_SESSION['tel_nr'] = $tel_nr;
                $_SESSION['user'] = new User($tel_nr);
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
