<?php

use UKMNorge\OAuth2\IdentityProvider\Facebook;
use UKMNorge\OAuth2\IdentityProvider\UKMID;
use UKMNorge\OAuth2\ID\UserManager;



error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();

require_once('UKMconfig.inc.php');
require_once('UKM/Autoloader.php');

switch ($_GET['provider']) {
    case 'ukmid':
        $identity_provider = new UKMID('delta', 'a42fb071e415fd9a31e7459fe51af2605c6fa04b');
        $identity_provider->setScope(['identify']);
        break;
    case 'facebook':
        $identity_provider = new Facebook(FACE_APP_ID, FACE_APP_SECRET);
        $identity_provider->setScope(['public_profile']);//,user_birthday']);
        break;
    default:
        throw new Exception('Unknown Identity Provider');
}

// Brukeren er ikke logget inn, men vi har fått en kode
// tilbake fra ID
if (isset($_GET['code'])) {
    $token = $identity_provider->exchangeCodeForAccessToken($_GET['code']);

    // Finne igjen brukeren i vårt system
    try {
        // Logg inn bruker
        $user = UserManager::loginUserFromProvider($_GET['provider'], $token->getData()->user_id);
    } catch( Exception $e ) {
        // Opprett bruker
        if( $e->getCode() == USER_DOES_NOT_EXIST_CODE ) {
            // Hent info om brukeren fra facebook
            $identity_provider->setAccessToken($token);
            $current_user = $identity_provider->getCurrentUser();
            
            $user = UserBundleIsh::createUserFromProvider($current_user);
            // oppretter bruker og kobler bruker og access token sammen.
            // kobler også provider_id og user_id
            // redirect til registreringssiden
        }
    }
}
// Brukeren er ikke logget inn. Start innlogging
else {
    // skal ikke komme hit, send til vanlig logginn-side
    header("Location: https://id.". UKM_HOSTNAME);
}
