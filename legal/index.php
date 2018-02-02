<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 02.02.18
 * Time: 22:47
 */

if (isset($_GET["legal"]))
{

    switch ($_GET["legal"]) {
        case "impressum":
            include "legal/impressum.php";
            break;
        case "datenschutz":
            include "legal/datenschutz.php";
            break;
        case "agb":
            include "legal/agb.php";
            break;
        case "widerruf":
            include "legal/widerruf.php";
            break;
        default:
            echo "Die Seite wurde nicht gefunden";
            die();
            break;
    }

} else {
    echo "Die Seite wurde nicht gefunden";
}