<?php

###########
# Author: Cody Halovich
# Client: Hootsuite
##########

// Setup class autoloading
require_once('../vendor/autoload.php');

// Load some config info
use Config\Router;

// Define Routing
$router = new Router();
$router->add('home','/','home');
$router->add('hashurl','/hash','hash');
$router->add('fullurl','/x','x');

// Launch appropriate Route based on URL requested
$URI = &$_SERVER['REQUEST_URI'];
try {
    echo $router->match($URI);
} catch (Exception $e) {
    echo 'Oops. 404: ' . $e->getMessage();
}

?>
