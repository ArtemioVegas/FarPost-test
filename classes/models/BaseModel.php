<?php
namespace Artemio\models;

use Artemio\services\{DatabaseConnect, ModelFactory};

class BaseModel {

    /**
     * @var \mysqli
     */
    public $db;

    /**
     * @var ModelFactory
     */
    protected $modelFactory;

    public static $tableName;
    public static $queryName;

    public function __get($name) {
        $result = null;

        if (property_exists($this, $name)) {
            $result = $this->$name;
        }

        return $result;
    }

    public function getTableName() {
        return static::$tableName;
    }

    public function setDb(DatabaseConnect $databaseConnect) {
        $this->db = $databaseConnect->getDB();

        return $this;
    }

    /**
     * @param ModelFactory $modelFactory
     * @return $this
     */
    public function setModelFactory(ModelFactory $modelFactory) {
        $this->modelFactory = $modelFactory;

        return $this;
    }

    public function findAllBy($where = array()) {
        $rows = [];
        $sql = 'SELECT * FROM ' . static::$tableName;

        if ($where) {
            $sql .= ' WHERE ' . key($where) . ' = ?';
        }

        $stmt = $this->db->prepare($sql);

        if ($where) {
            $element =  current($where);
			$stmt->bind_param('s', $element);
        }

        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_object(static::class)) {
            $row->setModelFactory($this->modelFactory);
            $rows[] = $row;
        }

        return $rows;
    }

    public function findOneBy($where) {
        $result = $this->modelFactory->getEmptyModel(static::class);
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE ' . key($where) . ' = ?';

        $stmt = $this->db->prepare($sql);
        $element =  current($where);
		$stmt->bind_param('s', $element);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res) {
            $result = $res->fetch_object(static::class);

            if ($result) {
                $result->setModelFactory($this->modelFactory);
                $result->db = $this->db;
            }
        }

        return $result;
    }

    protected function getDb() {
        $db = DatabaseConnect::getInstance()->getDB();

        return $db;
    }
}