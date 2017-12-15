<?php

include_once('db/connect.php');

$page = $_GET["page"];
$category = $_GET["category"];

$prepare_link = "?page=".$page."&category=".$category;

if ($_GET["category"] == "all") {

    $sql_count = "SELECT COUNT(*) c FROM products, categories WHERE products.category_id = categories.id";
    $result = $con->query($sql_count);
    $count = $result->fetch(PDO::FETCH_ASSOC);

    $total_count = $count["c"];

    $products_per_page = 3;

// Seitenzahl der letzten Produktseite
    $last = ceil ($total_count/$products_per_page);

    if($last < 1) {
        $last = 1;
    }

    $page_number = 1;

    if(isset($_GET["p"])) {
        $page_number = preg_replace("#[^0-9]#", "", $_GET["p"]);
    }

// Seitenzahl darf nicht kleiner als 0 und nicht größer als die letzte Zahl sein
    if($page_number < 1) {
        $page_number = 1;
    } else if ($page_number > $last) {
        $page_number = $last;
    }

    $limit = "LIMIT " .($page_number - 1) * $products_per_page . "," . $products_per_page;
    $sql = "SELECT products.*, categories.name AS cat_name FROM products, categories WHERE products.category_id = categories.id ORDER BY id ASC $limit ";

    $product_count_echo = $total_count . " Artikel";
    $site_count_echo = "Seite ".$page_number . " von " . $last;

    $pagination = "";

//Pagination nur anzeigen, wenn mehr als eine Seite vorhanden ist
    if($last != 1) {
        //Button zur vorherigen Seite, wird nicht auf der ersten Seite angezeigt
        if($page_number > 1) {
            $previous = $page_number - 1;
            $pagination .= '<a class="pag-item pagination-prev" href="'.$_SERVER['PHP_SELF'].$prepare_link.'&p='.$previous.'"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';

            //4 Zahlen links von der aktuellen Seite
            for($i = $page_number - 4; $i < $page_number; $i++) {
                if($i > 0) {
                    $pagination .= '<a class="pag-item pagination-link" href="'.$_SERVER['PHP_SELF'].$prepare_link.'&p='.$i.'">'.$i.'</a>';
                }
            }
        }

        //Aktuelle Seitenzahl
        $pagination .= '<span class="pag-item pagination-current">'.$page_number.'</span>';

        //4 Zahlen rechts von der aktuellen Seite
        for($i = $page_number + 1; $i <= $last; $i++) {
            $pagination .= '<a class="pag-item pagination-link" href="'.$_SERVER['PHP_SELF'].$prepare_link.'&p='.$i.'">'.$i.'</a>';
            if($i = $page_number + 4){
                break;
            }
        }

        //Button zur nächsten Seite
        if($page_number != $last) {
            $next = $page_number +1;
            $pagination .= '<a class="pag-item pagination-next" href="'.$_SERVER['PHP_SELF'].$prepare_link.'&p='.$next.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
        }
    }

?>

<h1>Alle Produkte</h1>
    <div class="category-info">
        <?php echo $site_count_echo; ?>
    </div>
    <div class="pwrapper">
        <?php
        foreach ($con->query($sql) as $row) {
            //placeholder abfrage
            if (!empty($row['img'])) {
                $imgurl = $row['img'];}
            else {
                $imgurl = "placeholder.jpg";
            }

            echo "<div class='box'>";
            echo "<div class='imagebox'><img class='pplaceholder' src='images/products/".$imgurl."' alt='product placeholder'>
            <div class='imageoverlay'>
            <div class='overlaycontent'><a href='index.php?page=product&product=show&id=".$row['id']."'>Details</a></div>
            </div></div>";
            echo "<div class='pdesc'><a class='ptitle' href='index.php?page=product&product=show&id=".$row['id']."'>".$row['name']."</a><br><span class='pprice'>".$row['price']." €</span></div>";
            echo "</div>";
        }
        ?>
    </div>
    <div id="pagination-wrapper">
        <div class="pagination-controls">
            <?php echo $pagination; ?>
        </div>
    </div>
<?php } ?>

<?php if ($_GET["category"] == "shirts") {?>

    <h1>Unsere Shirts</h1>
    <p>Inhalt folgt!</p>

<?php } ?>

<?php if ($_GET["category"] == "pullover") {?>

    <h1>Unsere Pullover</h1>
    <p>Inhalt folgt!</p>

<?php } ?>
