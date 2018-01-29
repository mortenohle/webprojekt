<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 19.11.17
 * Time: 19:58
 */

if($_POST["update"]) {

   /* $prod_id = $_POST['prod_id'];
    $new_qty = $_POST['quantity'];

    print_r($prod_id);
    print_r($new_qty);

    foreach( $prod_id as $key => $id ) {
        $_SESSION["cart"][$id] = $new_qty[$key];
    } */

   $newcart = $_POST["qty"];

   print_r($qty);

   $_SESSION["cart"] = $newcart;



   /* foreach($qty as $subkey => $subarray){
        if($subarray["prod_id"] == $prod_id){
            $_SESSION["cart"][$subkey]["quantity"] = $new_qty;
        }
    }
    $i = 0;

    foreach($_SESSION["cart"] as $subkey => $subarray){
        if($subarray["product_id"] == $qty[]["prod_id"]){
        $_SESSION["cart"][$subkey]["quantity"] = $qty[]["quantity"];
        }
        $i++;
    }
    print_r($_SESSION["cart"]); */

}
if($_POST["coupon"]) {

    echo "Aktuell ist die Gutschein Funktion inaktiv.";

}
if($_POST["checkout"]) {

    include_once('cart/checkout.php');
    

}

