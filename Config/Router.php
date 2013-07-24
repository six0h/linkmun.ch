<?php

###########
# Author: Cody Halovich
# Client: Hootsuite
##########

namespace Config;

use Controller\URLController;
use Library\Helper;

/**
 * Router class to handle requests and return appropriate controller methods
 */
class Router {

    protected $routes = array();

    public function __construct() {
        // Dust balls
    }

    /**
     * Add a path to the router (Add an endpoint to the API)
     */
    public function add($route,$path,$controller) {
       $route = array('route'=>$route,'path'=>$path,'controller'=>$controller);
       $this->routes[] = $route;
    }

    /**
     * Launches a controller method based on URI
     */
    public function match($URI) {
        $URI = preg_split('/\?/',$URI);
        $PATH = $URI[0];
        $path = preg_split('/\//', Helper::removeLeadingSlash($PATH));
        $params = $this->_getParamsFromPath($path);
        foreach($_REQUEST as $req) $params[] = $req;

        if($path[0] == '') {
            $path = '/';
        } else {
            $path = '/' . $path[0];
        }

        foreach($this->routes as $route) {
            if($route['path'] == $path) {
                $controller = new URLController(); 
                return $controller->$route['controller']($params);
            }
        }

        throw new \Exception("Sorry, Route not found in Configuration");
    }

    /**
     * Assign the parameters to their own array and remove them from the path
     */
    protected function _getParamsFromPath(&$path) {
        $params = array();
        if(count($path) > 1) {
            for($i = 1; $i < count($path); $i++)
                $params[] = $path[$i];
            $path = $path[0];
        } 
        return $params;
    }

    /**
     * Reverse a route name, returning a url (Great for links!)
     */
    public function getUrl($route) {
        foreach($this->routes as $r) {
            if($route == $r['route']) {
                return $r['path'];
            }

            throw new \Exception("Sorry, Route not found in configuration");
        }
    }

}

?>
