<?php

ini_set('display_errors',true);


use UKMNorge\Database\SQL\Query;
use UKMNorge\Design\UKMDesign;
use UKMNorge\Design\Sitemap\Section;
use UKMNorge\TemplateEngine\Proxy\Twig;
use UKMNorge\TemplateEngine\Vanilla;

error_reporting(E_ALL);
ini_set('display_errors',true);

require_once('vendor/autoload.php');
require_once('UKMconfig.inc.php');
require_once('UKM/Autoloader.php');
include_once('content/userManager.php');



/**
 * Init Vanilla
 */
Vanilla::setCacheDir(__DIR__.'/cache/');
Vanilla::init(__DIR__);

// Set where we are
UKMDesign::setCurrentSection(
    new Section(
        'current',
        'https://lite.ukm.dev/',
        'UKM lite'
    )
);

// The user is logged in
if(UserManager::isUserLoggedin()) {
    $user = UserManager::getLoggedinUser();

    if($user->isVilkaarAccepted()) {
        Vanilla::addViewData('user', $user);
        Vanilla::addViewData('ukmHostname', UKM_HOSTNAME);
        echo Vanilla::render('LoginInfo');
    }
    // Vilkaar er ikke godtatt
    else {
        Vanilla::addViewData('viewId', 'vilkaar');
        echo Vanilla::render('Login');
    }
    
// It is post
} else if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    // User credentials are correct
    if (UserManager::userLogin($_POST['username'], $_POST['password'])) {                    
        Vanilla::addViewData('user', UserManager::getLoggedinUser());
        Vanilla::addViewData('ukmHostname', UKM_HOSTNAME);
        echo Vanilla::render('LoginInfo');
    // User credentials are not correct
    }else {
        Vanilla::addViewData('errorMessage', "Wrong username or password!");
        echo Vanilla::render('Login');
    }
}
// Not logged in, not post
else {
    Vanilla::addViewData('viewId', '0');
    Vanilla::addViewData('ukmHostname', UKM_HOSTNAME);
    echo Vanilla::render('Login');
}

// var_dump(UserManager::userExists('+4746516244'));