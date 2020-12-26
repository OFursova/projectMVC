<?php
namespace Core\Libs;

use Core\Libs\Exceptions\DbException;

class Db {
    protected $pdo;
    private static $instance;

    private function __construct()
    {
        require_once __DIR__.'/../config.php';
        try{
        $this->pdo = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        }
        catch(\PDOException $e){
            throw new DbException(('Connection error to DB '.$e->getMessage()));
        }
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass') {
        $pz = $this->pdo->prepare($sql);
        $result = $pz->execute($params);
        if(!$result){return null;}
        return $pz->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}