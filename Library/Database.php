<?php

#######
# Author: Cody Halovich
# Client: Hootsuite
#######

namespace Library;

use \PDO;

class Database {

    protected $db;
    protected $username;
    protected $password;
    protected $hostname;
    protected $charset = "utf8";

    public function __construct($user,$pass,$host,$db) {
        $this->username = $user;
        $this->password = $pass;
        $this->hostname = $host;
        $this->db = new PDO("mysql:host={$host};dbname={$db};charset={$this->charset}", $user, $pass);
    }

    public function query($sql,$values = array(),$options = array()) {
        $db = $this->db;
        $query = $db->prepare($sql);
        $query->execute($values);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($sql,$values) {
        $args = array();
        $vals = array();
        foreach($values as $key => $value) {
           $args[] = $key;
           $vals[] = $value;
        }

        $query = $sql . " VALUES(" . implode(',',$args) . ");";
        $ex = $this->db->prepare($query);
        $ex->execute($values);
        return $ex->rowCount();
    }

    public function update($sql,$values) {
        throw new Exception('This has not been implemented', 500);
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }


}
