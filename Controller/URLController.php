<?php

namespace Controller;

use Model\URLModel;
use Model\Request;
use Config\SiteConfig;
use Library\Template;
use Library\Database;
use \ZMQContext;
use \ZMQSocket;
use \ZMQ;

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
        return $content;
    }

    public function er($params) {
        if(Request::isPOST()) {
            $context = new ZMQContext();
            //  Socket to talk to server
            $requester = new ZMQSocket($context, ZMQ::SOCKET_REQ);
            $requester->connect("tcp://127.0.0.1:5559");
            $req = array(
                'work' => 'generate',
                'url' => $params);
            $requester->send(json_encode($req));
            $response = $requester->recv();
            return $response;
        } else {
            $result = array(
                'code' => 503,
                'message' => 'This URL only allows POSTs'
            );

            return json_encode($result);
        }

    }

    public function y($params) {
        if(Request::isPOST()) {
            $context = new ZMQContext();
            //  Socket to talk to server
            $requester = new ZMQSocket($context, ZMQ::SOCKET_REQ);
            $requester->connect("tcp://127.0.0.1:5559");
            $req = array(
                'work' => 'return',
                'url' => $params);
            $requester->send(json_encode($req));
            $response = $requester->recv();
            return $response;
        } else {
            $result = array(
                'code' => 503,
                'message' => 'This URL only allows POSTs'
            );
            return json_encode($result);
        }

    }

    public function all() {
        $url = new URLModel($this->db);
    	return json_encode($url->getAll());
    }

}

?>
