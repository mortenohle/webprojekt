<?php

if (isset($_GET["action"]))
{

    switch ($_GET["action"]) {
        case "show":
            include "category/show.php";
            break;
        case "edit":
            include "category/edit.php";
            break;
        case "new":
            include "category/new.php";
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