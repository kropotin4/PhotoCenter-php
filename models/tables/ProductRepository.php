<?php

include "Product.php";

class ProductRepository {

    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function read($row) {
        $result = new Product();
        $result->product_id = $row["product_id"];
        $result->product_name = $row["product_name"];
        $result->product_price = $row["product_price"];
        $result->product_types_id = $row["product_types_id"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM products_t WHERE product_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll($filter) {
        $product_name = "%" . $filter["product_name"] . "%";
        $product_price = $filter["product_price"];
        $product_types_id = $filter["product_types_id"];

        $sql = "SELECT * FROM products_t
            WHERE product_name LIKE :product_name
            AND (:product_price = 0 OR product_price = :product_price)
            AND (:product_types_id = 0 OR product_types_id = :product_types_id)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":product_name", $product_name);
        $q->bindParam(":product_price", $product_price, PDO::PARAM_INT);
        $q->bindParam(":product_types_id", $product_types_id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO products_t (product_name, product_price, product_types_id)
                VALUES (:product_name, :product_price, :product_types_id)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":product_name", $data["product_name"]);
        $q->bindParam(":product_price", $data["product_price"]);
        $q->bindParam(":product_types_id", $data["product_types_id"]);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE products_t SET
            product_name = :product_name,
            product_price = :product_price,
            product_types_id = :product_types_id
            WHERE product_id = :product_id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":product_name", $data["product_name"]);
        $q->bindParam(":product_price", $data["product_price"]);
        $q->bindParam(":product_types_id", $data["product_types_id"]);
        $q->bindParam(":product_id", $data["product_id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM products_t WHERE product_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }

}

?>