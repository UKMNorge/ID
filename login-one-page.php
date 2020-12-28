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

// Vanilla::addViewData('innslags', $arrangement->getInnslag()->getAll());
// Vanilla::addViewData('personerSortert', sortPersoner($arrangement));
Vanilla::addViewData('ukmHostname', UKM_HOSTNAME);
echo Vanilla::render('Login');
