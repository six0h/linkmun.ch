<?php

namespace Config;

class SiteConfig {

    protected $config;

    public function __construct($file = '') {
        $config_dir = $this->getConfigDir();
        if($file == '') {
            $file = $config_dir . '/config.php';
        } else {
            $file = $config_dir . '/' . $file;
        }

        $this->config = require_once($file);
    }

    public function get($key) {
        if(array_key_exists($key,$this->config)) {
            return $this->config[$key];
        } else {
            return false;
        }
    }

    public function getConfigDir() {
        return dirname(__FILE__);
    }

}

?>
