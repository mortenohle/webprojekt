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


        $add_to_cart = array($product_id => $qty);

        array_merge($_SESSION["cart"], $add_to_cart);


    } else {

        $_SESSION["cart"] = array($product_id => $qty);

    }


}