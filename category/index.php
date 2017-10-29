<?php

if (isset($_GET["category"]))
{

    switch ($_GET["category"]) {
        case "all":
            include "category/show.php";
            break;
        case "shirts":
            include "category/show.php";
            break;
        case "pullover":
            include "category/show.php";
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