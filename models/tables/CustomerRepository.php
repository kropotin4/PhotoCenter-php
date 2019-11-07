<?php

include_once "Customer.php";

class CustomerRepository {

    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function read($row) {
        $result = new Customer();
        $result->customer_id = $row["customer_id"];
        $result->full_name = $row["full_name"];
        $result->age = $row["age"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM customers_t WHERE customer_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll() {
        $sql = "SELECT * FROM customers_t WHERE full_name LIKE :full_name AND age LIKE :age";
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
        $sql = "SELECT * FROM customers_t WHERE full_name LIKE :full_name AND age LIKE :age";
        $q = $this->db->prepare($sql);
        $q->bindParam(":full_name", $full_name = "%" . $filter["full_name"] . "%");
        $q->bindParam(":age", $age = "%" . $filter["age"] . "%");
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO customers_t (full_name, age)
                VALUES (:full_name, :age)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":full_name", $data["full_name"]);
        $q->bindParam(":age", $data["age"], PDO::PARAM_INT);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE customers_t SET
            full_name = :full_name,
            age = :age
            WHERE customer_id = :customer_id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":full_name", $data["full_name"]);
        $q->bindParam(":age", $data["age"], PDO::PARAM_INT);
        $q->bindParam(":customer_id", $data["customer_id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM customers_t WHERE customer_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }

}
