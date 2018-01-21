<?php

if (isset($_GET["page"]))
{

    switch ($_GET["action"]) {
        case "login":
            include "account/login.php";
            break;
        case "logout":
            include "account/logout.php";
            break;
        case "myprofile":
            include "account/profil.php";
            break;
        case "registrieren":
            include "account/registrieren.php";
            break;
        case "speichern":
            include "account/speichern.php";
            break;
        default:
            echo "Die Seite wurde nicht gefunden";
            die();
            break;
    }

} else {
    echo "Die Seite wurde nicht gefunden";
}