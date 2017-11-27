<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 19.11.17
 * Time: 19:47
 */

if (isset($_GET["id"])) {

    $delete_id = $_GET["id"];

    unset($_SESSION["cart"][$delete_id]);

    echo "Das Produkt wurde erfolgreich entfernt";


} else {
    echo "Die Seite wurde nicht gefunden";
}