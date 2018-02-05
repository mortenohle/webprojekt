<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 21.01.18
 * Time: 20:29
 */

include_once('db/connect.php');

$page = $_GET["page"];
$category = $_GET["category"];
$id = $_GET["category"];

$prepare_link = "?page=".$page."&category=".$category;

//Standard-Sortierung
$sql_sort = "ORDER BY id ASC";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sortby = $_POST["sortby"];

    if($sortby == 1) {
        $sql_sort = "ORDER BY id DESC";
    } elseif ($sortby == 2) {
        $sql_sort = "ORDER BY price ASC";
    } elseif ($sortby == 3) {
        $sql_sort = "ORDER BY price DESC";
    } else {
        $sql_sort = "ORDER BY id DESC";
    }
}


    $sql_count = "SELECT COUNT(*) c FROM products, categories WHERE products.category_id = ".$id;
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
    $sql = "SELECT *  FROM products WHERE category_id = $id $sql_sort $limit ";

    $product_count_echo = $total_count . " Artikel";
    $site_count_echo = "Seite ".$page_number . " von " . $last;

    $pagination = "";

//Pagination nur anzeigen, wenn mehr als eine Seite vorhanden ist
    if($last > 3) {
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
// Kategorie Namen erfragen

    $sql2 = "SELECT * FROM categories WHERE id = ".$id;
    $cat = $con->query($sql2);
    $result2 = $cat->fetch();

    ?>


    <h1><?php echo $result2["name"]; ?></h1>
    <div class="category-info">
        <div class="site-info">
            <?php echo $site_count_echo; ?>
        </div>
        <div class="product-sort">
            <form action="" method="post" id="sort">
                <div class="select-wrapper">
                    <select id="sortby" name="sortby">
                        <option value="0" <?php if($sortby == 0) {echo "selected";} ?>>Standardsortierung</option>
                        <option value="1" <?php if($sortby == 1) {echo "selected";} ?>>Neueste zuerst</option>
                        <option value="2" <?php if($sortby == 2) {echo "selected";} ?>>Preis aufsteigend</option>
                        <option value="3" <?php if($sortby == 3) {echo "selected";} ?>>Preis absteigend</option>
                    </select>
                </div>
            </form>
        </div>
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
