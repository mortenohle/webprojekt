<?php

if (isset($_GET["page"]))
{

    switch ($_GET["page"]) {
        case "search":
            include "search/search.php";
            break;
        default:
            echo "Die Seite wurde nicht gefunden";
            die();
            break;
    }

} else {
    echo "Die Seite wurde nicht gefunden 123";
}

?>