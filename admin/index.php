<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Adminbereich Webprojekt</title>
    <link href="css/style-admin.css" type="text/css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li class="home"><a href="../index.php">Zur Website</a></li>
            </ul>
        </nav>
    </header>

    <div id="sidemenu">
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="index.php?page=product&action=show">Produkte</a></li>
            <li><a href="#">Kategorien</a></li>
            <li><a href="#">Bestellungen</a></li>
        </ul>
    </div>

    <div id="admin-content">

        <?php

        if (isset($_GET["page"]) ) {

            switch ($_GET["page"]) {
                case "product":
                    include "product/index.php";
                    break;
                case "category":
                    include "category/index.php";
                    break;
                default:
                    include "start.php";
                    break;
            }
        }
        else
        {
            include "start.php";
        }

        ?>

    </div>

</body>