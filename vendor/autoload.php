<?php

require_once "_Autoload/Autoloader.php";

use _Autoload\Autoloader;



$projectDir = dirname( __DIR__ );


// initalize settings
Autoloader::$VENDOR_DIR = __DIR__;


// instanciate Autoloader
new Autoloader( $projectDir );