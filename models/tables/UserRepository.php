<?php

include "User.php";

class ProductTypeRepository {

    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function read($row) {
        $result = new User();
        $result->user_id = $row["user_id"];
        $result->user_login = $row["user_login"];
        $result->user_password = $row["user_password"];
        $result->user_sessid = $row["user_sessid"];
        $result->user_type = $row["user_type"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM user_t WHERE user_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll() {
        $sql = "SELECT * FROM user_t";
        $q = $this->db->prepare($sql);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }


    public function getAllFilter($filter) {
        $user_login = "%". $filter["user_login"] . "%";
        $user_type = "%" . $filter["user_type"] . "%";

        $sql = "SELECT * FROM user_t 
            WHERE user_login LIKE :user_login
            AND user_type LIKE :user_type";
        $q = $this->db->prepare($sql);
        $q->bindParam(":user_login", $user_login);
        $q->bindParam(":user_type", $user_type);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $user_login = $data["user_login"];
        $user_type = $data["user_type"];
        $user_password = password_hash($data["user_password"], PASSWORD_BCRYPT, ["cost" => 9]);

        $sql = "INSERT INTO user_t (user_login, user_password, user_type)
                VALUES (:user_login, :user_password, :user_type)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":user_login", $user_login);
        $q->bindParam(":user_password", $user_password);
        $q->bindParam(":user_type", $user_type, PDO::PARAM_INT);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $user_id = $data["user_id"];
        $user_login = $data["user_login"];
        $user_type = $data["user_type"];

        $sql = "UPDATE user_t SET
            user_login = :user_login,
            user_type = :user_type
            WHERE user_id = :user_id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":user_login", $user_login);
        $q->bindParam(":user_type", $user_type, PDO::PARAM_INT);
        $q->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM user_t WHERE user_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }
}