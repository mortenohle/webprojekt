<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 19.11.17
 * Time: 19:58
 */

if($_POST["update"]) {

    $prod_id = $_POST['prod_id'];
    $new_qty = $_POST['quantity'];

    foreach( $prod_id as $key => $id ) {
        $_SESSION["cart"][$id] = $new_qty[$key];
    }
}
if($_POST["coupon"]) {

    echo "Aktuell ist die Gutschein Funktion inaktiv.";

}
if($_POST["checkout"]) {

    include_once('cart/checkout.php');
    

}