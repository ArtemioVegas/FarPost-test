<?php
namespace Artemio\models;

class FileModel extends BaseModel {

    public static $tableName = 'files';

    protected $id;
    protected $user_id;
    protected $dt_add;
    protected $hash_name;
    protected $original_name;

    public function getFullPath() {
        $path = realpath(UPLOAD_PATH . '/' . $this->path);

        return $path;
    }

    public function saveNewFile($user_id,  $hash_name, $original_name) {
        $sql = 'INSERT INTO files (dt_add, user_id, hash_name, original_name) VALUES (NOW(), ?, ?, ?)';

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $user_id, \PDO::PARAM_INT);
        $stmt->bindParam(2, $hash_name, \PDO::PARAM_STR);
        $stmt->bindParam(3, $original_name, \PDO::PARAM_STR);
        $res = $stmt->execute();

        if ($res) {
            $res = $this->db->lastInsertId();
        }

        return $res;
    }
}