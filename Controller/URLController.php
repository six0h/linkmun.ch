<?php

namespace Controller;

use Model\URLModel;
use Model\Request;
use Config\SiteConfig;
use Library\Template;
use Library\Database;

class URLController {

    protected $template;
    protected $db;

    public function __construct() {
        $this->template = new Template();

        $config = new SiteConfig();
        $db_config = $config->get('Database');
        $this->db = new Database($db_config['user'],$db_config['pass'],$db_config['host'],$db_config['name']);
    }

    public function home($params = array()) {
        $tpl = $this->template;
        $content = $tpl->render('index.html.twig',$params);
        echo $content;
    }

    public function hash($params) {
        if(Request::isPOST()) {
            $result = array(
                'code' => 200,
                'link' => 'k2j302u309u',
                'params' => $params
            );
        } else {
            $result = array(
                'code' => 503,
                'message' => 'This URL only allows POSTs'
            );
        }

        return json_encode($result);
    }

    public function x($params) {
        if(Request::isPOST()) {
            $result = array(
                'code' => 200,
                'link' => 'k2j302u309u',
                'params' => $params
            );
        } else {
            $result = array(
                'code' => 503,
                'message' => 'This URL only allows POSTs'
            );
        }

        return json_encode($result);
    }

}

?>
