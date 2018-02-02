<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 19.11.17
 * Time: 19:47
 */

//Everything below is deprecated. Just leave it as a Fallback Solution

if (isset($_GET["id"])) {


// Warenkorb Elemente zählen
    $cart_items = $_SESSION["cart"];
    $cart_count = count($cart_items);

    $delete_id = $_GET["id"];

if ($cart_count < 2) { unset($_SESSION["cart"]); } else {
    foreach($_SESSION["cart"] as $subkey => $subarray){
        if($subarray["product_id"] == $delete_id){
            unset($_SESSION["cart"][$subkey]);
        }
    }}

     /* $key = array_search($del_val, $_SESSION["cart"]);
    if (false !== $key) {
        unset($array[$key]);
    }

    foreach ($_SESSION["cart"] as $b) {
        if ($b[0] == $delete_id) {
            $name = $b[1];
            break;
        }
    }

    unset($_SESSION["cart"][$delete_id]); */

    echo "Das Produkt wurde erfolgreich entfernt";


} else {
    echo "Die Seite wurde nicht gefunden";
}