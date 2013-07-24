<?php

#######
# Author: Cody Halovich
# Client: Hootsuite
#######

require_once("vendor/autoload.php");

use Model\URLModel;
use Config\SiteConfig;
use Library\Database;

// Setup Database and inject into Model
$config = new SiteConfig();
$db_config = $config->get('Database');
$db = new Database($db_config['user'],$db_config['pass'],$db_config['host'],$db_config['name']);
$URLModel = new URLModel($db);

// Setup ZMQ
$context = new ZMQContext(1);
$responder = new ZMQSocket($context, ZMQ::SOCKET_REP);
$responder->connect("tcp://127.0.0.1:5560");
error_log("Worker Ready");

while(true) {

    // RECV from ZMQ
    $request = $responder->recv();

    // If there is content...
    if($request) {

        // Make sure we're dealing with JSON
        error_log("Received Request: " . $request);
        try {
            $request = json_decode($request,true);
        } catch (Exception $e) {
            $response = array('code'=>500,'message'=>'Something inappropriate happened. Try again.');
            $responder->send(json_encode($response));
            break;
        }

        // Check kind of work and perform as necessary
        if($request['work'] == 'generate') {
            $url = $URLModel->generateShortURL($request['url'][0]);
            error_log('Generated ' . $url);
        } elseif ($request['work'] == 'return') {
            $url = $URLModel->findByShort($request['url']);
            error_log('Reversed ' .$url[0]);
        }
        $response = array('code'=>200,'url'=>$url);
        $responder->send(json_encode($response));
        error_log("Sent Response: " . json_encode($response));

    }


}

?>
