<?php

if (isset($_GET["search"]))
{

    switch ($_GET["search"]) {
        case "searchterm":
            include "search/search.php";
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