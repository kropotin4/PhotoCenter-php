<?php

include "Consultant.php";

class ConsultantRepository {

    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function read($row) {
        $result = new Consultant();
        $result->consultant_id = $row["consultant_id"];
        $result->full_name = $row["full_name"];
        $result->passport_data = $row["passport_data"];
        $result->phone = $row["phone"];
        $result->sex = $row["sex"];
        $result->birth_date = $row["birth_date"];
        $result->pc_id = $row["pc_id"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM consultants_t WHERE consultant_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll($filter) {
        $full_name = "%" . $filter["full_name"] . "%";
        $passport_data = "%" . $filter["passport_data"] . "%";
        $pc_id = $filter["pc_id"];

        $sql = "SELECT * FROM consultants_t WHERE full_name LIKE :full_name AND passport_data LIKE :passport_data AND (:pc_id = 0 OR pc_id = :pc_id)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":full_name", $full_name);
        $q->bindParam(":passport_data", $passport_data);
        $q->bindParam(":pc_id", $pc_id);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO consultants_t (full_name, passport_data, phone, sex, birth_date, pc_id)
                VALUES (:full_name, :passport_data, :phone, :sex, :birth_date, :pc_id)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":full_name", $data["full_name"]);
        $q->bindParam(":passport_data", $data["passport_data"]);
        $q->bindParam(":phone", $data["phone"]);
        $q->bindParam(":sex", $data["sex"]);
        $q->bindParam(":birth_date", $data["birth_date"]);
        $q->bindParam(":pc_id", $data["pc_id"], PDO::PARAM_INT);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE consultants_t SET
            full_name = :full_name,
            passport_data = :passport_data,
            phone = :phone,
            sex = :sex,
            birth_date = :birth_date,
            pc_id = :pc_id
            WHERE consultant_id = :consultant_id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":full_name", $data["full_name"]);
        $q->bindParam(":passport_data", $data["passport_data"]);
        $q->bindParam(":phone", $data["phone"]);
        $q->bindParam(":sex", $data["sex"]);
        $q->bindParam(":birth_date", $data["birth_date"]);
        $q->bindParam(":pc_id", $data["pc_id"], PDO::PARAM_INT);
        $q->bindParam(":consultant_id", $data["consultant_id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM consultants_t WHERE consultant_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":consultant_id", $id, PDO::PARAM_INT);
        $q->execute();
    }

}

?>