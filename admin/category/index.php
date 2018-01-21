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
        case "editsuccess":
            include "category/edit.php";
            break;
        case "new":
            include "category/new.php";
            break;
        case "newsuccess":
            include "category/new.php";
            break;
        case "delete":
            include "category/delete.php";
            break;
        case "deletesuccess":
            include "category/delete.php";
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