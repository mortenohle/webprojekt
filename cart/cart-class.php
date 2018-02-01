<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 28.01.18
 * Time: 13:06
 */

class cart {

    private $conn;

    public function __construct($con) {
        $this->conn = $con;
    }

    public function check_cart() {
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
    }
    public function addtocart($id, $quantity, $size) {

        $stock = new stockmanagement($this->conn);

        if ($stock->isavaible($id, $quantity, $size)) {

            if (isset($_SESSION["cart"])) {

            foreach ($_SESSION["cart"] as $subkey => $subarray) {
                if ($subarray["product_id"] == $id && $subarray["size"] == $size) {
                    $_SESSION["cart"][$subkey]["quantity"] += $quantity;
                } else {
                    $add_to_cart = array("product_id" => $id, "quantity" => $quantity, "size" => $size);
                    // $_SESSION["cart"] = array_merge_recursive( (array)$_SESSION["cart"], (array)$add_to_cart );
                    array_push($_SESSION["cart"], $add_to_cart);
                }

            }

        } else { $_SESSION["cart"] = array(array("product_id" => $id, "quantity" => $quantity, "size" => $size)); }

            echo "<span>Das Produkt wurde zum Warenkorb hinzugefügt. <a href='index.php?page=cart&cart=show'>Zum Warenkorb</a> </span>";

        } else { echo "Die gewählte Größe, Menge des Produkts ist leider nciht mehr auf Lager.";}

    }

    public function updateall($newcart) {

        $_SESSION["cart"] = $newcart;


    }
    public function updatesingle($id, $quantity) {

        foreach ($_SESSION["cart"] as $subkey => $subarray) {
            if ($subarray["product_id"] == $id) {
                $_SESSION["cart"][$subkey]["quantity"] += $quantity;
            }
        }
    }

    public function cartcount() {

        $cart_items = $_SESSION["cart"];
        return count($cart_items);
    }

    public function isempty() {

        return $this->cartcount() <= 0;
    }

}