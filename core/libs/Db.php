<?php
namespace Core\Libs;

class Db {
    protected $pdo;
    private static $instance;

    private function __construct()
    {
        require_once __DIR__.'/../config.php';
        $this->pdo = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
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