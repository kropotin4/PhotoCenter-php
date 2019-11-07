<?php

include "Service.php";

class ServiceRepository {

    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function read($row) {
        $result = new Service();
        $result->service_id = $row["service_id"];
        $result->consultant_id = $row["consultant_id"];
        $result->product_id = $row["product_id"];
        $result->customer_id = $row["customer_id"];
        $result->service_date = $row["service_date"];
        $result->service_time = $row["service_time"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM service_t WHERE service_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll() {
        $sql = "SELECT * FROM service_t";
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
        $sql = "SELECT * FROM service_t WHERE service_date LIKE :service_date AND service_time LIKE :service_time
            AND (:consultant_id = 0 OR consultant_id = :consultant_id)
            AND (:product_id = 0 OR product_id = :product_id)
            AND (:customer_id = 0 OR customer_id = :customer_id)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":service_date", $service_date = "%" . $filter["service_date"] . "%");
        $q->bindParam(":service_time", $service_time = "%" . $filter["service_time"] . "%");
        $q->bindParam(":consultant_id", $filter["consultant_id"], PDO::PARAM_INT);
        $q->bindParam(":product_id", $filter["product_id"], PDO::PARAM_INT);
        $q->bindParam(":customer_id", $filter["customer_id"], PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO service_t (consultant_id, product_id, customer_id, service_date, service_time)
                VALUES (:consultant_id, :product_id, :customer_id, :service_date, :service_time)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":service_date", $data["service_date"]);
        $q->bindParam(":service_time", $data["service_time"]);
        $q->bindParam(":consultant_id", $data["consultant_id"], PDO::PARAM_INT);
        $q->bindParam(":product_id", $data["product_id"], PDO::PARAM_INT);
        $q->bindParam(":customer_id", $data["consultant_id"], PDO::PARAM_INT);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE service_t SET
            consultant_id = :consultant_id,
            product_id = :product_id,
            customer_id = :customer_id,
            service_date = :service_date,
            service_time = :service_time
            WHERE service_id = :service_id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":service_date", $data["service_date"]);
        $q->bindParam(":service_time", $data["service_time"]);
        $q->bindParam(":consultant_id", $data["consultant_id"]);
        $q->bindParam(":product_id", $data["product_id"], PDO::PARAM_INT);
        $q->bindParam(":customer_id", $data["customer_id"], PDO::PARAM_INT);
        $q->bindParam(":service_id", $data["service_id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM service_t WHERE service_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }

}
