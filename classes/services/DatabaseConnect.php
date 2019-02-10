<?php
namespace Artemio\services;

class DatabaseConnect {

    private static $instance;
    /**
     * @var \PDO
     */
    private $pdo;

    public static function getInstance($params = null) {
        if (!self::$instance) {
            self::$instance = new self($params);
        }

        return self::$instance;
    }

    /**
     * @return \PDO
     */
    public function getDB() {
        return $this->pdo;
    }

    private function __construct($params = null) {
        if ($params) {
            $dns = $params['driver'] .
                ':host=' . $params['host'] .
                ((!empty($params['port'])) ? (';port=' . $params['port']) : '') .
                ';dbname=' . $params['database'];

            $this->pdo = new \PDO($dns, $params['user'],$params['password'], $params['options']);
        }
    }
}