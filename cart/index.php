<?php
/**
 * Created by PhpStorm.
 * User: Morten
 * Date: 06.11.17
 * Time: 12:01
 */#

if (isset($_GET["cart"]))
{

    switch ($_GET["cart"]) {
        case "show":
            include "cart/show.php";
            break;
        case "update":
            include "cart/update.php";
            break;
        case "delete":
            include "cart/delete.php";
            break;
        case "checkout":
            include "cart/checkout.php";
            break;
        default:
            echo "Die Seite wurde nicht gefunden";
            die();
            break;
    }

} else {
    echo "Die Seite wurde nicht gefunden";
}

?>