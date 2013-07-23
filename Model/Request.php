<?php

namespace Model;

class Request {

    protected $headers;

    public function __construct() {
        $this->headers = getallheaders();
    }

    public static function isPOST() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

}

?>
