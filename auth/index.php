<?php

include_once('../autoload.php');

use Entities\User;
use UKMNorge\OAuth2\IdentityProvider\Facebook;
use UKMNorge\OAuth2\IdentityProvider\Google;
use UKMNorge\OAuth2\IdentityProvider\UKMID;
use UKMNorge\OAuth2\ID\UserManager;


error_reporting(E_ALL);
ini_set('display_errors', true);

require_once('UKMconfig.inc.php');
require_once('UKM/Autoloader.php');


$identity_provider = null;

switch ($_GET['provider']) {
    case 'facebook':
        $identity_provider = new Facebook(UKM_FACE_APP_ID, UKM_FACE_APP_SECRET);
        $identity_provider->setScope(['public_profile']);//,user_birthday']);
        break;
    case 'google':
        $identity_provider = new Google(UKM_GOOGLE_APP_ID, UKM_GOOGLE_APP_SECRET);
        $identity_provider->setScope(['public_profile']);//,user_birthday']);
        break;
    default:
        throw new Exception('Unknown Identity Provider');
}

// Brukeren er ikke logget inn, men vi har fått en kode
// tilbake fra ID
if (isset($_GET['code'])) {
    try {
        $token = $identity_provider->exchangeCodeForAccessToken($_GET['code']);
    } catch(Exception $e) {
        die($e->getMessage());
    }

    $identity_provider->setAccessToken($token);
    $current_user = $identity_provider->getCurrentUser();

    $userIDfromIP = $current_user->getId();

    $accessToken = $token->getToken();
    $idToken = $token->getIdToken();
    
    if(UserManager::isUserLoggedin()) {
        header("Location: https://id.". UKM_HOSTNAME);
        die;
    }

    try {
        // Logg inn bruker
        $user = UserManager::userLoginFromProvider($accessToken, $_GET['provider'], $idToken);
        header("Location: https://id.". UKM_HOSTNAME);
    } catch( Exception $e ) {
        echo 'User not found, register...';
        // die("CREATE USER");
        // Opprett bruker
        // Bruk e->getCode() to identify the error
        if( true /*$e->getCode() == USER_DOES_NOT_EXIST_CODE*/ ) {
            // Hent info om brukeren fra facebook
            UserManager::startUserCreateFromProvider($_GET['provider'], $current_user->getId(), $accessToken, $idToken);
            header("Location: https://id.". UKM_HOSTNAME . '?pageId=telNrProvider');

        }
    }
}
// Brukeren er ikke logget inn. Start innlogging
else {
    // skal ikke komme hit, send til vanlig logginn-side
    header("Location: https://id.". UKM_HOSTNAME);
}
