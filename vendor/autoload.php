<?php

require_once "azmok/autoloader/src/Autoloader.php";

use Autoloader\Autoloader;





// initalize settings
Autoloader::$VENDOR_DIR = __DIR__;
Autoloader::$PROJECT_DIR = dirname( __DIR__ );

// instanciate Autoloader
new Autoloader();