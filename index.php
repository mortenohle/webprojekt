<?php
    session_start();
    include_once('db/connect.php');
include_once "cart/stock-class.php";
    include_once "cart/cart-class.php";

    $cart = new cart($con);
    $stock = new stockmanagement($con);
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Webprojekt Onlineshop</title>
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/slider.js"></script>
    <script type="text/javascript">
        jQuery.query = { numbers: false, hash: false };
    </script>
    <script type="text/javascript" src="js/jquery.query-object.js"></script>
</head>

<body>
<header class="transition">
    <div class="inner-wrapper">
        <a href="index.php">
            <div class="logo-mobile">
                <span class="logo">Logo</span>
            </div>
        </a>
        <div class="mobile-menu-toggle">
            <img src="images/menu.svg" alt="Menü">
            <img src="images/close.svg" alt="Menü" style="display: none;">
        </div>
        <div class="nav-wrap">
            <div class="nav-left">
                <nav>
                    <ul class="transition">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php?page=category&category=all">Produkte</a>
                            <ul>
                                <li><a href="index.php?page=category&category=2">Shirts</a></li>
                                <li><a href="index.php?page=category&category=1">Jacken</a></li>
                                <li><a href="index.php?page=category&category=3">Hemden</a></li>
                            </ul>
                        </li>
                        <li><a href="index.php?page=about">Über uns</a></li>
                    </ul>
                </nav>
            </div>
            <a href="index.php">
                <div class="logo-container">
                    <span class="logo">Logo</span>
                </div>
            </a>
            <div class="nav-right">
                <ul class="">
                    <?php if(isset($_SESSION["username"])) { ?>
                       <li class="loggedinuser">Hallo, <?php echo $_SESSION['username']; ?>
                           <ul class="transition">
                               <div class="user-dropdown-wrap">
                               <li class="user-profile"><a href="index.php?page=account&action=myprofile">Mein Profil</a></li>
                               <li class="user-orders"><a href="#">Meine Bestellungen</a></li>
                               <li class="user-logout"><a href="index.php?page=account&action=logout">Abmelden</a></li>
                               </div>
                           </ul>
                       </li>
                    <?php } else { ?>
                        <li><a href='index.php?page=account&action=login'>Einloggen</a></li>
                        <li><a href='index.php?page=account&action=registrieren'>Registrieren</a></li>
                    <?php } ?>

                    <li class="warenkorb loggedinuser"><?php if (!$cart->isempty()) { ?><span class="warenkorb-bubble"><?php echo $cart->cartcount(); ?></span><?php }?><a href="index.php?page=cart&cart=show"><img src="images/warenkorb.svg" alt="Warenkorb"><span class="li-cart-mobile">Warenkorb</span></a>
                        <?php if (!$cart->isempty()) { ?>
                        <ul class="transition">
                            <div class="user-dropdown-wrap cartwidget">
                                <?php $cart->getcartwidget(); ?>


                            </div>
                        </ul>
                    </li>
                <?php } ?>
                    <li class="toggle-search"><img src="images/suche.svg" alt="Suche" class="search-icon"></li>
                </ul>
            </div>
            <div class="mobile-search-input">
                <?php include ('search/search_form.php'); ?>
            </div>
        </div>
    </div>
</header>

<div id="search-input-wrapper">
    <div class="inner-wrapper search-desk">
        <?php include ('search/search_form.php'); ?>
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
                        <a class="btn-link" href="index.php?page=category&category=all">Zu unseren Produkten</a>
                    </div>
                </div>
            </li>
            <li style="background-image: url(images/slide_02.jpg);">
                <div class="inner-wrapper">
                    <div class="slide-content dark">
                        <span class="slide-heading">Hemden</span>
                        <p>Businesslooks, die überzeugen!<br>Entdecke unsere Hemden.</p>
                        <a class="btn-link" href="index.php?page=category&category=3">Zu unseren Hemden</a>
                    </div>
                </div>
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
                case "cart":
                    include "cart/index.php";
                    break;
                case "search":
                    include "search/index.php";
                    break;
                case "account":
                    include "account/index.php";
                    break;
                case "legal":
                    include "legal/index.php";
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
    <div class="social-bar">
        <a href="#">
             <div class="transition social-icon facebook">
             <i class="fa fa-facebook" aria-hidden="true"></i>
             </div>
        </a>
        <a href="#">
            <div class="transition social-icon twitter">
                               <i class="fa fa-twitter" aria-hidden="true"></i>
            </div>
        </a>
        <a href="#">
            <div class="transition social-icon instagram">
                               <i class="fa fa-instagram" aria-hidden="true"></i>
            </div>
        </a>
    </div>
    <div class="footer-menu">
               <ul>
                       <li><a href="index.php?page=legal&legal=widerruf">Widerrufsbelehrung</a></li>
                   <li><a href="index.php?page=legal&legal=agb">AGBs</a></li>
                   <li><a href="index.php?page=legal&legal=datenschutz">Datenschutz</a></li>
                   <li><a href="index.php?page=legal&legal=impressum">Impressum</a></li>
               </ul>
    </div>
       <div class="footer-bottom-text">
               Made with <i class="fa fa-heart-o" aria-hidden="true"></i> in Stuttgart
           <span class="copyright">&copy; 2018 by LOGO - Luxury Original Glamorous Outfits</span>
       </div>
</footer>

</body>
</html>