<?php

#######
# Author: Cody Halovich
# Client: Hootsuite
#######

namespace Model;

use Library\Database;

class URLModel {

    protected $id = null;
    protected $full_url;
    protected $short_url;
    protected $date_created;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * Find by providing a Long URL
     */
    public function findByURL($url) {
        $db = $this->db;
        try {
            $results = $db->query("SELECT * FROM urls WHERE long_url = ?",array($url));
        } catch (Exception $e) {
            throw new Exception('There was a problem with the database, try again.');
        }

        foreach($results as $result) {
            $this->short_url    = $result['shortUrl'];
            $this->long_url     = $result['longUrl'];
            $this->id           = $result['id'];
            $this->date_created = $result['date_created'];
        }

        return $this->short_url();
    }

    /**
     * Find by providing a Short URL
     */
    public function findByShort($id) {
        $db = $this->db;
        try {
            $results = $db->query("SELECT * FROM urls WHERE shortUrl = ?",array($id));
        } catch (Exception $e) {
            throw new Exception('There was a problem with the database, try again.');
        }

        foreach($results as $result) {
            $this->short_url    = $result['shortUrl'];
            $this->long_url     = $result['longUrl'];
            $this->id           = $result['id'];
            $this->date_created = $result['date_created'];
        }

        return $this->long_url;
    }

    /**
     * Generate a Short URL and Store it to the database
     * Alternately, grab the existing ID if it's already in the database
     */
    public function generateShortURL($url) {
        $this->full_url = $url;
        $this->short_url = substr(md5($url),0,6);
        $this->date_created = date('c');
        $this->commit();
        return $this->short_url;
    }

    public function getID() {
        return $this->id;
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function getShortURL() {
        return $this->short_url;
    }

    public function setShortURL($url) {
        $this->$short_url = $url;
    }

    public function getFullURL() {
        return $this->full_url;
    }

    public function setFullURL($url) {
        $this->full_url = $url;
    }

    public function getDateCreated() {
        return $this->date_created;
    }

    public function setDateCreated($date) {
        $this->date_created = $date;
    }

    public function commit() {
        $db = $this->db;
        if(is_int($this->id)) {
            // Already Stored, Don't Store A Duplicate
        } else {
            $query = "INSERT INTO urls (shortUrl,longUrl,date_created)";
            $values = array(
                ":shortUrl" => $this->getShortURL(),
                ":longUrl" => $this->getFullURL(),
                ":date_created" => $this->getDateCreated());
            $result = $this->db->insert($query,$values);
            if($result == 1) {
                $this->id = $this->db->getLastInsertId();
            } elseif ($result < 1) {
                $query = "SELECT * FROM urls WHERE short_url = ?";
                $values = array($this->getShortURL());
                $result = $db->query($query,$values);
                foreach($result as $res) {
                    $this->id = $res['id'];
                }
            }
        }
    }

    public function asArray() {
        return array(
            'id' => $this->id,
            'shortUrl' => $this->short_url,
            'longUrl' => $this->full_url,
            'dateCreated' => $this->date_created);
    }

    public function getAll() {
        $query = "SELECT * FROM urls";
        $values = array();
        return $this->db->query($query);
    }

}
