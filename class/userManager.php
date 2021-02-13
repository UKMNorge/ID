<?php

namespace UKMNorge\OAuth2\ID;

use DateTime;
use Exception;
use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\User;
use UKMNorge\OAuth2\TempUser;

class UserManager {
    private static $storage;
    private static $user;

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
        
        // Login only if the user is not verified from before
        if($res) {
            static::userLogin($tel_nr, $password);
            return true;
        }
        
        return false; // The user is already verified
    }

    // Add URI to session and bind it with an id
    // Returns id
    public static function addCallbackURIToSession(string $uri) : string {
        $id = static::$storage::generateRandomToken();
        // Validate URI with client URI IMPORTANT:::::::::IMPORTANT::::::::::IMPORTANT

        $_SESSION['callback_uri'] = array(
            // NOTE: token is used as id
            'id' => $id,
            'uri' => $uri
        );
        
        return $id;
    }

    // Redirect to callback URI if it exists
    // This method will clean the session callback_uri if the redirection is fulfilled
    public static function redirectCallbackURI(string $id, bool $getUri = false) {
        if (isset($_SESSION['callback_uri'])) {
            $callbackUri = $_SESSION['callback_uri'];
            if(!empty($callbackUri) && $callbackUri['id'] == $id) {
                unset($_SESSION["callback_uri"]);
                if($getUri) {
                    return $callbackUri['uri'];
                }
                else{
                    header('Location: ' . $callbackUri['uri']);
                }
            }
        }
        return null;
    }

    public static function setVilkaarToAccepted() : bool {
        if(static::isUserLoggedin()) {
            $user = static::getLoggedinUser();

            $status = static::$storage->setVilkaarToAccepted($user);
            $user->setVilkaarToAccepted();

            return $status;
        }

        throw new Exception("Brukeren er ikke logged inn derfor vilkaar kan ikke lagres");
    }

    // Get user by providing access token
    public static function getUserByAccessToken(string $accessToken, string $scope) {
        return static::$storage->getUserByAccessToken($accessToken, $scope);   
    }

    // Check if session is active
    public static function isUserLoggedin() {
        return static::$storage->isUserLoggedin();
    }

    /**
     * Get currently logged in user
     * 
     * @return User
     * @throws Exception
     */
    public static function getLoggedinUser() {
        if(static::isUserLoggedin()) {
            if( is_null(static::$user)) {
                static::$user = User::getById($_SESSION['user_id']);
            }
            return static::$user;
        }
        throw new Exception('Brukeren er ikke logged inn');
    }

    // Check if user exist by providing tel_nr
    public static function userExistsByTelNr(string $tel_nr) {
        $userId = static::telNrToUserId($tel_nr);
        
        if($userId == null) return false;

        return static::userExistsById(static::telNrToUserId($tel_nr));
    }
    
    // Check if user exist by providing userId
    public static function userExistsById(string $userId) {
        return static::$storage->userExists($userId);
    }

    public static function userLogout() {        
        // Unset all session variables
        $_SESSION = array();
        session_destroy();
    }

    public static function telNrToUserId($telNr) {
        try{
            return static::$storage->telNrToId($telNr);
        } catch(Exception $e) {
            return null;
        }
    }

    public static function parseTelNr(string $tel_nr) : string {
        // Fjern +47 hvis det er lagt til
        if(substr($tel_nr, 0, 3-strlen($tel_nr)) == '+47') {
            $tel_nr = substr($tel_nr, 3);
        }
        return $tel_nr;
    }

    // User login with tel_nr
    public static function userLogin(string $tel_nr, string $password) : bool {
        $tel_nr = static::parseTelNr($tel_nr);
        $userId = static::telNrToUserId($tel_nr);

        if($userId == null) {
            return false;
            static::userLogout();
        }

        try{
            // Logged in, save session data
            if(static::$storage->checkUserCredentials($userId, $password)) {
                // create Session
                static::setLoginToSession($userId);
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

    // User login through Identity Providers
    public static function userLoginFromProvider($userIdSP, $provider, $accessToken) {
        // Sjekk om brukeren eksisterer med provider id
        $result = static::$storage->checkUserCredentialsWithSP($userIdSP, $provider, $accessToken);

        if($result) {
            static::setLoginToSession($userIdSP);
        }
        else {
            throw new Exception('Credentials are not correct or user has not been found!');
        }

    }

    private static function setLoginToSession(string $userId) : void {
        $_SESSION['valid'] = true;
        $_SESSION['user_id'] = $userId;
    }

    private static function getUserByTelNr($tel_nr) : User {
        return new User(static::telNrToUserId($tel_nr));
    }

    // Oppdater bruker info
    public static function updateUserInfo(string $tel_nr, string $firstName = null, string $lastName = null) {
        $user = static::getUserByTelNr($tel_nr);

        if($firstName) {
            $user->setFirstName($firstName);
        }
        if($lastName) {
            $user->setLastName($lastName);
        }

        $user->save();
    }

    public static function changePassword(string $tel_nr, string $password) : bool {
        $user = static::getUserByTelNr($tel_nr);

        return $user->changePassword($password);
    }

    public static function setVerifiedUser($tel_nr) : bool {
        $user = static::getUserByTelNr($tel_nr);
        return $user->setTelNrVerified();
    }

    public static function createUserFromProvider($providerUser) {
        // Provider user (IdentityProvider\Basic\User)
        // Hent data fra ...Basic\User og inkluder extra data om der er nødvendig, f.eks. tel_nr
        // Eventuelt redirect til registrering av ny bruker med utfylt informasjon from provider

    }

}

$userManager = new UserManager();