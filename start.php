<?php
include_once('db/connect.php');
?>
<div class='startintro'>
<h1>Neues aus unserem Shop</h1>
    <div class="category-filter" style="display: none;">
        <ul>
            <li><a href="#">Alle anzeigen</a></li>
            <?php
            $sql_cat = "SELECT categories.*, products.name AS p_name FROM categories INNER JOIN products ON categories.id = products.category_id ORDER BY id ASC";
            foreach ($con->query($sql_cat) as $row_cat) {
                echo "<li> ".$row_cat["name"]."</li>";
            }
            ?>
        </ul>
    </div>
</div>

<div class="pwrapper">

<?php

$sql = "SELECT * FROM products ORDER BY id ASC";

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
