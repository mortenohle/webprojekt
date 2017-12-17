<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 06.11.17
 * Time: 22:35
 */


if (isset($_POST["product"]) && $_POST["quantity"] > 0 ) {

    $product_id = $_POST["product"];
    $qty = $_POST["quantity"];

    if (isset($_SESSION["cart"])) {


        foreach($_SESSION["cart"] as $subkey => $subarray){
            if(isset($subarray["product_id"]) == $product_id){
                $_SESSION["cart"][$subkey]["quantity"] += $qty;
            } else {
                $add_to_cart = array("product_id" => $product_id, "quantity" => $qty);
                // $_SESSION["cart"] = array_merge_recursive( (array)$_SESSION["cart"], (array)$add_to_cart );
                array_push($_SESSION["cart"], $add_to_cart);
            }

        }


    } else {

        $_SESSION["cart"] = array(array("product_id" => $product_id, "quantity" => $qty));

    }


}
echo "Session Cart:";
print_r($_SESSION["cart"]);
echo "Add To Cart:";
print_r($add_to_cart);