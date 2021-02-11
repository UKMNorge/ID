<?php

/**
 * @file: id.ukm.dev/auth/index.php
 * 
 */

// CLIENT-IMPLEMENTATION FOR
// UKM-ID:
// https://bshaffer.github.io/oauth2-server-php-docs/grant-types/authorization-code/

use UKMNorge\Http\Curl;
use UKMNorge\OAuth2\IdentityProvider\Basic\AccessToken;
use UKMNorge\OAuth2\IdentityProvider\Facebook;
use UKMNorge\OAuth2\IdentityProvider\UKMID;

error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();

echo 'GET';
var_dump($_GET);

require_once('UKMconfig.inc.php');
require_once('UKM/Autoloader.php');

switch ($_GET['provider']) {
    case 'ukmid':
        $identity_provider = new UKMID('delta', 'a42fb071e415fd9a31e7459fe51af2605c6fa04b');
        $identity_provider->setScope(['identify']);
        break;
    case 'facebook':
        $identity_provider = new Facebook(FACE_APP_ID, FACE_APP_SECRET);
        $identity_provider->setScope(['public_profile']); // ???
        break;
    default:
        throw new Exception('Unknown Identity Provider');
}

if(isset($_GET['logout'])) {
    unset($_SESSION);
    echo 'Du er nå logget ut';
}
elseif (isset($_SESSION['accessToken']) && !isset($_GET['code'])) {
    echo 'Har token aka er logget inn.';

    $tokendata = json_decode($_SESSION['accessToken']);
    echo '<pre>';
    var_dump($tokendata);
    echo '</pre>';

    // Hent info om brukeren
    $identity_provider->setAccessToken(
        new AccessToken($tokendata->token)
    );

    var_dump($identity_provider->getCurrentUser());

    echo '<a href="?logout=true">Logg ut</a>';
}
// Brukeren er ikke logget inn, men vi har fått en kode
// tilbake fra ID
elseif (isset($_GET['code'])) {
    $token = $identity_provider->exchangeCodeForAccessToken($_GET['code']);

    $_SESSION['accessToken'] = json_encode([
        'token' => $token->getToken(),
        'data' => $token->getData()
    ]);

    echo 'Fikk svar fra ID: ' .
        '<p>' .
        '<b>Dette er responsen fra CURL-requesten delta sendte til ID: 👇</b>' .
        '<code><pre>' .
        var_export($token, true) .
        '<code></pre>' .
        '</p>' .
        '<p><a href="/">Refresh siden for å være logget inn</a></p>';
}
// Brukeren er ikke logget inn. Start innlogging
else {
    echo 'Redirect to ID for login: <a href="' . $identity_provider->getAuthUrl() . '">Logg inn</a>';
}
