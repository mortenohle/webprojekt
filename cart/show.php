<?php
/**
 * Created by PhpStorm.
 * User: Morten
 * Date: 06.11.17
 * Time: 12:02
 */

if (isset($_POST["product"]) && $_POST["quantity"] > 0 ) {

    $product_id = $_POST["product"];
    $qty = $_POST["quantity"];

    if (isset($_SESSION["cart"])) {

        array_push($_SESSION["cart"], $product_id => $qty);


    } else {

        $_SESSION["cart"] = array($product_id => $qty);

    }


}