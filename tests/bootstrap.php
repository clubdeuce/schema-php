<?php

define('SRC_DIR', dirname(__DIR__) . '/src');
define('VENDOR_DIRECTORY', dirname(__DIR__) . '/vendor');

if(file_exists(VENDOR_DIRECTORY . '/autoload.php'))
    require VENDOR_DIRECTORY . '/autoload.php';

require 'includes/testCase.php';