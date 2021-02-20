<?php

namespace UKMNorge\OAuth2\ID;

use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\Session\Session;
use UKMNorge\OAuth2\ServerMain;
use UKMNorge\OAuth2\User;
use UKMNorge\OAuth2\TempUser;
use UKMNorge\OAuth2\ID\SessionManager;
use UKMNorge\OAuth2\IdentityProvider\Basic\User as IPUser;

use UKMNorge\OAuth2\IdentityProvider\Facebook;
use UKMNorge\OAuth2\IdentityProvider\Google;
use UKMNorge\OAuth2\IdentityProvider\Basic\AccessToken;

ini_set("display_errors", true);



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

    public static function userExists($tel_nr) {
        return static::$storage->userExists($tel_nr);
    }

    public static function userLogout() {        
        // Unset all session variables
        unset($_SESSION['valid']);
        unset($_SESSION['tel_nr']);
        unset($_SESSION['user_id']);
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
                $_SESSION['user_id'] = $tel_nr;
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

    public static function changePassword(string $tel_nr, string $password) : bool {
        $user = new User($tel_nr);
        return $user->changePassword($password);
    }

    public static function setVerifiedUser($tel_nr) : bool {
        $user = new User($tel_nr);
        return $user->setTelNrVerified();
    }

    private static function generateRandomPassword() : string {
        return static::$storage->generateRandomToken() . '9Z';
    }

    private static function setLoginToSession(string $userId) : void {
        $_SESSION['valid'] = true;
        $_SESSION['user_id'] = $userId;
    }

    private static function setUserVerify($tel_nr) : bool {
        return static::$storage->setUserToVerified($tel_nr);
    }


    /* ----------------------------- User Provider ------------------------------*/
    
    /**
     * Hent bruker (User) ved å oppgi access token and provider navn
     *
     * @param string $accessToken - access token fra provider
     * @param string $provider - provider navn f.eks. 'Facebook'
     * @return User
     */
    public static function getUserByAccessToken(string $accessToken, $provider, $idToken=null) : User {
        try{
            $userFromProvider = static::getBasicUser($accessToken, $provider, $idToken);
        } catch(Exception $e) {
            die($e->getMessage());
        }
        
        $user = static::$storage->getUserProvider($userFromProvider->getId(), $provider);

        if($user == null) {
            throw new Exception('The user for this access token has not been found!');
        }

        return $user;
    }

    /**
     * Hent bruker Basic User (IdentityProvider\Basic\User) ved å oppgi access token and provider navn
     *
     * @param string $accessToken - access token fra provider
     * @param string $provider - provider navn f.eks. 'Facebook'
     * @return IPUser
     */
    private static function getBasicUser(string $accessToken, string $provider, $idToken=null) : IPUser {
        if($provider == 'facebook') {
            $identityProvider = new Facebook(UKM_FACE_APP_ID, UKM_FACE_APP_SECRET);
        }
        else if($provider == 'google') {
            $identityProvider = new Google(UKM_FACE_APP_ID, UKM_FACE_APP_SECRET);
        }
        else {
            throw new Exception('Provider med navn ' . $provider . ' støttes ikke!');
        }

        $identityProvider->setAccessToken(new AccessToken($accessToken, $idToken));
        return $identityProvider->getCurrentUser();
    }

    /**
     * Bruker login med access token og provider navn
     *
     * @param string $accessToken - access token fra provider
     * @param string $provider - provider navn f.eks. 'Facebook'
     * @return bool
     */
    public static function userLoginFromProvider($accessToken, $provider, $idToken=null) : bool {
        try {
            $user = static::getUserByAccessToken($accessToken, $provider, $idToken);
            if($user != null) {
                static::setLoginToSession($user->getTelNr());
                return true;
            }
            static::userLogout();
            throw new Exception('User login failed 0!');
        } catch(Exception $e) {
            static::userLogout();
            throw new Exception('User login failed 1!');
        }
    }

    /**
     * Registrer ny bruker gjennom provider. Det betyr at en bruker i oauth_user skal opprettes. Denne brukeren skal kobles med brukeren som hentes fra user_identity_provider med access token lagret i SessionManager.
     * NOTE: startUserCreateFromProvider() skal kalles først, før man kaller denne metoden
     *
     * @param string $accessToken - access token fra provider
     * @param string $provider - provider navn f.eks. 'Facebook'
     * @return bool
     */
    public static function registerNewUserProvider(string $telNr) : bool {
        // Sjekk hvis brukeren med tel_nr ekisterer
        if(static::$storage->userExists($telNr)) {
            throw new Exception('Brukeren ' . $telNr . ' eksisterer derfor kan ikke opprettes');
        }

        $provider = $accessToken = SessionManager::getValueWithTimeout('providerName');
        
        try{
            $accessToken = SessionManager::getValueWithTimeout('providerAccessToken');
            $idToken = SessionManager::getValueWithTimeout('providerIdToken');
        } catch(Exception $e) {
            echo $e->getMessage(); // Timeout
            return false;
        }

        if(!$accessToken) {
            echo ' Redirect to provider login... ';
            header('Refresh: 4; URL=https://id.'. UKM_HOSTNAME);
            return false;
        }

        try{
            $basicUser = static::getBasicUser($accessToken, $provider, $idToken);
        } catch(Exception $e) {
            echo 'Basic user has not been provided by provider. Check access token';
            return false;
        }
        
        $birthday = DateTime::createFromFormat('Y-m-d', '2000-01-01');

        $user = static::registerNewUser($telNr, static::generateRandomPassword(), $basicUser->getFirstName(), $basicUser->getLastName(), $birthday);
        
        if(!$user) return false;
        
        // Add telNr to the user_provider DB
        static::$storage->addUserToProvider($telNr, $basicUser->getId(), $provider);

        // Get the registered user by accessToken
        try{
            static::setUserVerify($telNr);
            $user = static::getUserByAccessToken($accessToken, $provider, $idToken);
            // Login
            static::userLoginFromProvider($accessToken, $provider, $idToken);
            return true;
        } catch(Exception $e) {
            echo $e->getMessage();
            return false;
        }

        return false;
    }


    /**
     * Start brukeropprettelse gjennom provider. Denne metoden lagres provider access token og provider navn i SessionManager
     * Denne metoden opprettes en ny bruker i user_identity_provider uten kobling med oauth_user
     * 
     * 
     * @param string $provider - provider navn f.eks. 'facebook'
     * @param string $userIdSP - bruker id fra provider
     * @param string $accessToken - access token fra provider
     * @return void
     */
    public static function startUserCreateFromProvider(string $provider, string $userIdSP, string $accessToken, string $idToken=null) {
        $timeout = 10*60; // 10 min

        SessionManager::setWithTimeout('providerAccessToken', $accessToken, $timeout);
        SessionManager::setWithTimeout('providerIdToken', $idToken, $timeout);
        SessionManager::setWithTimeout('providerName', $provider, $timeout);
        
        static::$storage->registerUserWithServiceProvider($userIdSP, $provider, $accessToken);
    }
    
}

$userManager = new UserManager();
