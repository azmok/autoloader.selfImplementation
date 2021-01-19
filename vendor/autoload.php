<?php

require_once "azmok/Autoload/src/Autoloader.php";

use \Autoloader;





// initalize settings
Autoloader::$VENDOR_DIR = __DIR__;
Autoloader::$PROJECT_DIR = dirname( __DIR__ );

// instanciate Autoloader
new Autoloader();