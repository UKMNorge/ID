<?php

// Config
require_once('UKMconfig.inc.php');

// UKMlib classes
require_once('UKM/Autoloader.php');
// UKMlib vendors
require_once('UKM/vendor/autoload.php');

// Local vendors
require_once('vendor/autoload.php');

// Local (ID) classes
spl_autoload_register(function ($class_name) {
    if( strpos( $class_name, 'UKMNorge\\OAuth2\\ID' ) === 0 ) {
        $file = __DIR__ . str_replace(
            ['\\', 'UKMNorge/OAuth2/ID'], 
            ['/', '']
            , '/class'. $class_name
        ) .'.php';

        #echo ' TRY &lt;'. $class_name .'&gt; @ PATH: &lt;'. $file .'&gt;';

        if( file_exists( $file ) ) {
            require_once( $file );
        }
    }
});