<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 29.10.17
 * Time: 22:37
 */
if (isset($_GET["product"]))
{

    switch ($_GET["product"]) {
        case "show":
            include "product/show.php";
            break;
        case "rate":
            include "product/kundenbewertung.php";
            break;
        case "ratesuccess":
            include "product/speichern_kundenbewertung.php";
            break;
        default:
            echo "Die Seite wurde nicht gefunden";
            die();
            break;
    }

} else {
    echo "Die Seite wurde nicht gefunden";
}