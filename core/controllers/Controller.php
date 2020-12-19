<?php
namespace Core\Controllers;
use Core\Libs\Db;

class Controller{
    protected $db;
    public function __construct()
    {
        //echo __METHOD__ .'<br>';
        $this->db = new Db();
    }

    public function dump($obj) {
        echo '<pre>' . print_r($obj, true) . '</pre>';
    }
}