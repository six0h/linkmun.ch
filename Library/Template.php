<?php

###########
# Author: Cody Halovich
# Client: Hootsuite
##########

namespace Library;

use \Twig_Loader_Filesystem;
use \Twig_Environment;

class Template {

    protected $twig;

    public function __construct() {

        // Load Twig (Templating)
        // FYI: This is the only 3rd party library on this site
        // FYI: Other than jQuery, of course...
        $loader = new Twig_Loader_Filesystem('../Templates');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => dirname(dirname(__FILE__)) . '/cache'
        ));
        
    }

    public function render($file,$parameters) {
        $tpl = $this->twig;
        return $tpl->render($file,$parameters);
    }

}
