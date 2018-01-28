<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 28.01.18
 * Time: 13:06
 */

class cart {

    public function check_cart() {
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
    }
    public function addtocart($id, $quantity)
    {

        if (isset($_SESSION["cart"])) {

            foreach ($_SESSION["cart"] as $subkey => $subarray) {
                if ($subarray["product_id"] == $id) {
                    $_SESSION["cart"][$subkey]["quantity"] += $quantity;
                } else {
                    $add_to_cart = array("product_id" => $id, "quantity" => $quantity);
                    // $_SESSION["cart"] = array_merge_recursive( (array)$_SESSION["cart"], (array)$add_to_cart );
                    array_push($_SESSION["cart"], $add_to_cart);
                }

            }

        } else { echo "Warenkorb wurde nicht gefunden."; }

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

        return count($this->cartcount() <= 0);
    }

}