<?php

include_once "PhotoCenter.php";

class PhotoCenterRepository {

    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function read($row) {
        $result = new PhotoCenter();
        $result->pc_id = $row["pc_id"];
        $result->address = $row["address"];
        $result->chains_name = $row["chains_name"];
        $result->office_hours = $row["office_hours"];
        $result->phone = $row["phone"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM photo_centers_t WHERE pc_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll($filter) {
        $address = "%" . $filter["address"] . "%";
        $chains_name = "%" . $filter["chains_name"] . "%";
        $office_hours = "%" . $filter["office_hours"] . "%";
        $phone = "%" . $filter["phone"] . "%";

        $sql = "SELECT * FROM photo_centers_t
            WHERE address LIKE :address
            AND chains_name LIKE :chains_name
            AND office_hours LIKE :office_hours
            AND phone LIKE :phone";
        $q = $this->db->prepare($sql);
        $q->bindParam(":address", $address);
        $q->bindParam(":chains_name", $chains_name);
        $q->bindParam(":office_hours", $office_hours);
        $q->bindParam(":phone", $phone);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO photo_centers_t (address, chains_name, office_hours, phone)
                VALUES (:address, :chains_name, :office_hours, :phone)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":address", $data["address"]);
        $q->bindParam(":chains_name", $data["chains_name"]);
        $q->bindParam(":office_hours", $data["office_hours"]);
        $q->bindParam(":phone", $data["phone"]);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE photo_centers_t SET
            address = :address,
            chains_name = :chains_name,
            office_hours = :office_hours,
            phone = :phone
            WHERE pc_id = :pc_id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":address", $data["address"]);
        $q->bindParam(":chains_name", $data["chains_name"]);
        $q->bindParam(":office_hours", $data["office_hours"]);
        $q->bindParam(":phone", $data["phone"]);
        $q->bindParam(":pc_id", $data["pc_id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM clients WHERE pc_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }

}

?>