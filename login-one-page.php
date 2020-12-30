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



// Midlertidig (Må legges til på head)
echo '<style>';
include 'style/login.css';
echo '</style>';


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
if(UserManager::isSessionActive()) {
    Vanilla::addViewData('user', UserManager::getLoggedinUser());
    Vanilla::addViewData('ukmHostname', UKM_HOSTNAME);
    echo Vanilla::render('LoginInfo');
// It is post
} else if (isset($_POST['login']) && !empty($_POST['tel_nr']) && !empty($_POST['password'])) {
    // User credentials are correct
    if (UserManager::userLogin($_POST['tel_nr'], $_POST['password'])) {                    
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
    Vanilla::addViewData('ukmHostname', UKM_HOSTNAME);
    echo Vanilla::render('Login');
}

// var_dump(UserManager::userExists('+4746516244'));