<?php
namespace Artemio\models;

class UserModel extends BaseModel {

    protected $id;
    protected $dt_add;
    protected $email;
    protected $name;
    protected $password;

    public static $tableName = 'users';

    public function createNewUser($email, $password, $name) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = $this->generateHash([$email, $password, $name]);

        $sql = 'INSERT INTO users (dt_add, email, name, password, token) VALUES (NOW(), ?, ?, ?, ?)';

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $email, \PDO::PARAM_STR);
        $stmt->bindParam(2, $name, \PDO::PARAM_STR);
        $stmt->bindParam(3, $password, \PDO::PARAM_STR);
        $stmt->bindParam(4, $token, \PDO::PARAM_STR);
        $res = $stmt->execute();

        return $res;
    }

    public function updateToken($token) {
        $sql = 'UPDATE ' . static::$tableName . ' SET token = ? WHERE id = ?';

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $token, \PDO::PARAM_STR);
        $stmt->bindParam(2, $this->id, \PDO::PARAM_INT);
        $res = $stmt->execute();

        return $res;
    }

    public function generateHash(array $user_data) {
        $ts  = microtime(true);
        $str = implode(';', array_merge([$ts], $user_data));

        $hash = md5($str);

        return $hash;
    }
}