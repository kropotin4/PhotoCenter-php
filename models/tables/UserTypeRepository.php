<?php

include "UserType.php";

class UserTypeRepository {

    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function read($row) {
        $result = new UserType();
        $result->user_type_id = $row["user_type_id"];
        $result->consultants_t = $row["consultants_t"];
        $result->customers_t = $row["customers_t"];
        $result->photo_centers_t = $row["photo_centers_t"];
        $result->products_t = $row["products_t"];
        $result->product_types_t = $row["product_types_t"];
        $result->service_t = $row["service_t"];
        $result->users_t = $row["users_t"];
        $result->user_types_t = $row["user_types_t"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM user_types_t WHERE user_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll() {
        $sql = "SELECT * FROM user_types_t";
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
        $sql = "SELECT * FROM user_types_t
            WHERE (consultants_t LIKE :consultants_t)
            AND (customers_t LIKE :customers_t)
            AND (photo_centers_t LIKE :photo_centers_t)
            AND (products_t LIKE :products_t)
            AND (product_types_t LIKE :product_types_t)
            AND (service_t LIKE :service_t)
            AND (users_t LIKE :users_t)
            AND (user_types_t LIKE :user_types_t)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":consultants_t",     $n = '%' . $filter["consultants_t"] . '%');
        $q->bindParam(":customers_t",       $n = '%' . $filter["customers_t"] . '%');
        $q->bindParam(":photo_centers_t",   $n = '%' . $filter["photo_centers_t"] . '%');
        $q->bindParam(":products_t",        $n = '%' . $filter["products_t"] . '%');
        $q->bindParam(":product_types_t",   $n = '%' . $filter["product_types_t"] . '%');
        $q->bindParam(":service_t",         $n = '%' . $filter["service_t"] . '%');
        $q->bindParam(":user_types_t",      $n = '%' . $filter["user_types_t"] . '%');
        $q->bindParam(":users_t",      $n = '%' . $filter["users_t"] . '%');
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO user_types_t (consultants_t, customers_t, photo_centers_t, products_t, product_types_t, service_t, user_types_t)
                VALUES (:consultants_t, :customers_t, :photo_centers_t, :products_t, :product_types_t, :service_t, :user_types_t)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":consultants_t", $data["consultants_t"]);
        $q->bindParam(":customers_t", $data["customers_t"]);
        $q->bindParam(":photo_centers_t", $data["photo_centers_t"]);
        $q->bindParam(":products_t", $data["products_t"]);
        $q->bindParam(":product_types_t", $data["product_types_t"]);
        $q->bindParam(":service_t", $data["service_t"]);
        $q->bindParam(":user_types_t", $data["user_types_t"]);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE user_types_t SET
            consultants_t = :consultants_t,
            photo_centers_t = :photo_centers_t,
            products_t = :products_t,
            product_types_t = :product_types_t,
            service_t = :service_t,
            users_t = :users_t,
            user_types_t = :user_types_t
            WHERE user_type_id = :user_type_id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":consultants_t", $data["consultants_t"]);
        $q->bindParam(":customers_t", $data["customers_t"]);
        $q->bindParam(":photo_centers_t", $data["photo_centers_t"]);
        $q->bindParam(":products_t", $data["products_t"]);
        $q->bindParam(":product_types_t", $data["product_types_t"]);
        $q->bindParam(":service_t", $data["service_t"]);
        $q->bindParam(":user_types_t", $data["user_types_t"]);
        $q->bindParam(":user_type_id", $data["user_type_id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM user_types_t WHERE user_id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }

}