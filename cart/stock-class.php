<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 30.01.18
 * Time: 09:43
 */

class stockmanagement  {

    private $conn;

    public function __construct($con) {
        $this->conn = $con;
    }


    public function isavaible($id, $qty, $size) {

        $statement = $this->conn->prepare("SELECT * FROM stock WHERE product_id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result2 = $statement->fetch();

        if ($result2[$size] >= $qty) {
            $avaible = true;
        } else { $avaible = false;}

        return $avaible;
    }

    public function reducestock($id, $qty, $size) {

        $statement = $this->conn->prepare("UPDATE stock SET :size = size - :qty WHERE product_id = :id ");
        $statement->bindParam(':size', $size);
        $statement->bindParam(':qty', $qty);
        $statement->bindParam(':id', $id);
        $statement->execute();

    }
    public function howmany($id, $size) {

        $statement = $this->conn->prepare("SELECT * FROM stock WHERE product_id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result2 = $statement->fetch();

        return $result2[$size];
    }
}