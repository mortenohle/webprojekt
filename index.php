
    <!doctype html>
    <html>
<head>
    <meta charset="UTF-8">
    <title>Adminbereich Webprojekt</title>
    <link href="css/style-admin.css" type="text/css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css"
          rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/backend.js"></script>
</head>

<body>
<header>
    <nav>
        <ul>
            <li class="home"><a href="../index.php">Zur Website</a></li>
        </ul>
    </nav>
    <div class="user-info">
        <!--<a href="session/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>-->
    </div>
</header>

<div id="sidemenu">
    <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="index.php?page=product&action=show">Produkte</a></li>
        <li><a href="index.php?page=category&action=show">Kategorien</a></li>
        <li><a href="#">Bestellungen</a></li>
    </ul>
</div>

<div id="admin-content">

    <?php

    if (isset($_GET["page"])) {

        switch ($_GET["page"]) {
            case "orders":
                include "start.php";
                break;
            default:
                include "start.php";
                break;
        }
    } else {
        include "start.php";
    }

    ?>

</div>

</body>
