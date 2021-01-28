<?php


use UKMNorge\Design\UKMDesign;
use UKMNorge\Design\Sitemap\Section;
use UKMNorge\OAuth2\ID\UserManager;
use UKMNorge\TemplateEngine\Vanilla;

error_reporting(E_ALL);
ini_set('display_errors',true);

require_once('autoload.php');

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
        echo Vanilla::render('LoginInfo');
    }
    // Vilkaar er ikke godtatt
    else {
        Vanilla::addViewData('viewId', 'vilkaar');
        Vanilla::addViewData('user', $user);
        echo Vanilla::render('Login');
    }
    
// It is post
} else if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    // User credentials are correct
    if (UserManager::userLogin($_POST['username'], $_POST['password'])) {                    
        $user = UserManager::getLoggedinUser();
        Vanilla::addViewData('user', $user);
        if($user->isVilkaarAccepted()) {
            echo Vanilla::render('LoginInfo');
        }
        else {
            Vanilla::addViewData('viewId', 'vilkaar');
            Vanilla::addViewData('user', $user);
            echo Vanilla::render('Login');
        }
    // User credentials are not correct
    }else {
        Vanilla::addViewData('errorMessage', "Wrong username or password!");
        echo Vanilla::render('Login');
    }
}
// Not logged in, not post
else {
    echo Vanilla::render('Login');
}

// var_dump(UserManager::userExists('+4746516244'));