<?php

include "AccessRight.php";


class AccessRightRepository {

    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function read($row) {
        $result = new AccessRight();
        $result->right_id = ($row["right_id"]);
        $result->right_name = $row["right_name"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM access_rights_t WHERE right_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll() {
        $sql = "SELECT * FROM access_rights_t";
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
        $sql = "SELECT * FROM access_rights_t
            WHERE right_name LIKE :right_name";
        $q = $this->db->prepare($sql);
        $q->bindParam(":right_name", $right_name = "%" . $filter["right_name"] . "%");
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO access_rights_t (right_name)
                VALUES (:right_name)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":right_name", $data["right_name"]);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE access_rights_t SET
            right_name = :right_name
            WHERE right_id = :right_id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":right_name", $data["right_name"]);
        $q->bindParam(":right_id", $data["right_id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM access_rights_t WHERE right_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }

}