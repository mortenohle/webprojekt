<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Webprojekt Onlineshop</title>
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/slider.js"></script>
</head>

<body>
<header class="transition">
    <div class="inner-wrapper">
        <div class="nav-left">
            <nav>
                <ul class="transition">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php?page=category&category=all">Kategorien</a>
                        <ul>
                            <li><a href="index.php?page=category&category=shirts">Shirts</a></li>
                            <li><a href="index.php?page=category&category=pullover">Pullover</a></li>
                        </ul>
                    </li>
                    <li><a href="index.php?page=about">Über uns</a></li>
                </ul>
            </nav>
        </div>
        <div class="logo-container">
            <span class="logo">Logo</span>
        </div>
        <div class="nav-right">
            <ul class="">
                <li>Einloggen</li>
                <li class="warenkorb"><img src="images/warenkorb.svg" alt="Warebkorb"></li>
                <li class="toggle-search"><img src="images/suche.svg" alt="Suche" class="search-icon"></li>
            </ul>
        </div>
    </div>
</header>

<div id="search-input-wrapper">
    <div class="inner-wrapper">
        <form>
            <div class="search-input">
                <input type="text" name="main-search" id="main-search" placeholder="Suchbegriff eingeben">
            </div>
            <div class="search-submit">
                <button type="submit">
                    <img src="images/search_input.svg" alt="Suchen">
                </button>
            </div>
        </form>
    </div>
</div>

<?php if (!isset($_GET["page"]) ) { ?>

    <div id="main-slider">
        <ul>
            <li style="background-image: url(images/slide_01.jpg);">
                <div class="inner-wrapper">
                    <div class="slide-content">
                        <span class="slide-heading">All Black</span>
                        <p>Ausgewählte und hochwertige Designerstücke.<br>Entdecke unsere neue All Black Kollektion.</p>
                        <a class="btn-link" href="#">Mehr erfahren</a>
                    </div>
                </div>
            </li>
            <li style="background-image: url(images/slide_02.jpg);">
                <div class="content"><a href="http://imageslidermaker.com">Slide Two</a></div>
            </li>
            <li style="background-image: url(images/slide_03.jpg);">

            </li>
        </ul>
        <div class="slide-nav prev transition"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
        <div class="slide-nav next transition"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
    </div><!-- main-slider -->

<?php } ?>

<div id="content">
    <div class="inner-wrapper content">

        <?php

        if (isset($_GET["page"]) ) {

            switch ($_GET["page"]) {
                case "category":
                    include "category/index.php";
                    break;
                case "about":
                    include "about/index.php";
                    break;
                case "product":
                    include "product/index.php";
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
</div>

<footer>
    <p>Footer Webprojekt</p>
</footer>

</body>
</html>