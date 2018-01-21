<?php

if (isset($_GET["action"]))
{

    switch ($_GET["action"]) {
        case "show":
            include "product/show.php";
            break;
        case "edit":
            include "product/edit.php";
            break;
        case "editsuccess":
            include "product/edit.php";
            break;
        case "new":
            include "product/new.php";
            break;
        case "newsuccess":
            include "product/new.php";
            break;
        case "delete":
            include "product/delete.php";
            break;
        case "deletesuccess":
            include "product/delete.php";
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