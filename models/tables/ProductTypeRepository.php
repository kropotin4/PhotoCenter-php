<?php

include "ProductType.php";

class ProductTypeRepository {

    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function read($row) {
        $result = new ProductType();
        $result->product_types_id = $row["product_types_id"];
        $result->product_types_name = $row["product_types_name"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM product_types_t WHERE product_types_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll($filter) {
        $sql = "SELECT * FROM product_types_t";
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
        $sql = "SELECT * FROM product_types_t WHERE product_types_name LIKE :product_types_name";
        $q = $this->db->prepare($sql);
        $q->bindParam(":product_types_name", $product_types_name = "%" . $filter["product_types_name"] . "%");
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO product_types_t (product_types_name)
                VALUES (:product_types_name)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":product_types_name", $data["product_types_name"]);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE product_types_t SET
            product_types_name = :product_types_name
            WHERE product_types_id = :product_types_id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":product_types_name", $data["product_types_name"]);
        $q->bindParam(":product_types_id", $data["product_types_id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM product_types_t WHERE product_types_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }

}
