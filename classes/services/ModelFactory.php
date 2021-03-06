<?php
namespace Artemio\services;

use Artemio\models\BaseModel;

class ModelFactory {

    private static $instance;

    /**
     * @var DatabaseConnect
     */
    protected $databaseConnect;

    public static function getInstance(DatabaseConnect $databaseConnect = null) {
        if (!self::$instance) {
            self::$instance = new self($databaseConnect);
        }

        return self::$instance;
    }

    public function getEmptyModel($className) : BaseModel {
        $model = new $className;
        $model->setDb($this->databaseConnect)->setModelFactory($this);

        return $model;
    }

    public function load($className, $id) : BaseModel {
        $table = $className::$tableName;

        $sql = 'SELECT * FROM ' . $table . ' WHERE id = ? LIMIT 1';

        $stmt = $this->databaseConnect->getDB()->prepare($sql);
        $stmt->bindParam(1, $id, \PDO::PARAM_INT);
        $stmt->execute();

        $model = $stmt->fetchObject($className);
        $model->setDb($this->databaseConnect)->setModelFactory($this);

        return $model;
    }

    private function __construct(DatabaseConnect $databaseConnect = null) {
        if ($databaseConnect) {
            $this->databaseConnect = $databaseConnect;
        }
    }

    public function getDatabaseConnect()
    {
        return $this->databaseConnect;
    }
}