<?php

if (isset($_GET["category"]))
{

    switch ($_GET["category"]) {
        case "all":
            include "category/show.php";
            break;
        default:
            include "category/product_loop.php";
            break;
    }

} else {
    echo "Die Seite wurde nicht gefunden";
}

?>