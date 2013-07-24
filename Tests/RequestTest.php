<?php

require_once('../vendor/autoload.php');

use Model\Request;
use \PHPUnit_Framework_TestCase;

class RequestTest extends PHPUnit_Framework_TestCase {

    public function testIsPost() {
        $this->assertTrue($_SERVER['REQUEST_METHOD'] != 'POST');
    }

}

?>
