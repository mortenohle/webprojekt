<?php
    include_once('../db/connect.php');
    $categoryid = $_GET['category'];
?>
<h1>Produkte</h1>

<div class="row-full-width">
    <a class="btn-link" href="index.php?page=product&action=new">Produkt hinzufügen</a>

    <div class="product-category-row">
        <ul class="product-category">

            <?php

                // Anzahl aller Produkte
                $sql_count_all = "SELECT COUNT(*) c FROM products";
                $result = $con->query($sql_count_all);
                $count = $result->fetch(PDO::FETCH_ASSOC);
            ?>

            <li><a href="index.php?page=product&action=show">Alle</a> <span class="item-count">(<?php echo $count["c"]; ?>)</span></li>

            <?php
                // SQL Abfrage der Kategorien
                $sql_cat = "SELECT * FROM categories";

                foreach ($con->query($sql_cat) as $row_cat) {

                    $cat_id = $row_cat["id"];

                    // Anzahl der Produkte einer Kategorie
                    $sql_count_category = "SELECT COUNT(*) d FROM products WHERE category_id =".$cat_id;
                    $result_count = $con->query($sql_count_category);
                    $count_category = $result_count->fetch(PDO::FETCH_ASSOC);

                    echo "<li><a href='index.php?page=product&action=show&category=".$row_cat['id']."'>".$row_cat['name']."</a> <span class='item-count'>(".$count_category['d'].")</span></li>";
                }
            ?>
        </ul>
    </div>

    <div class="product-row heading">
        <div class="product-col">
           Bild
        </div>
        <div class="product-col">
            Name
        </div>
        <div class="product-col">
            Art.-Nr.
        </div>
        <div class="product-col">
            Kategorie
        </div>
        <div class="product-col">
            Preis
        </div>
        <div class="product-col">

        </div>
    </div>


<?php

if ($categoryid == "") {
    $sql = "SELECT products.*, categories.name AS cat_name FROM products JOIN categories ON products.category_id = categories.id ORDER BY id ASC";
} else {
    $sql = "SELECT products.*, categories.name AS cat_name FROM products JOIN categories ON products.category_id = categories.id WHERE products.category_id = ".$categoryid." ORDER BY id ASC";
}

foreach ($con->query($sql) as $row) {

    // Abfrage Produktbild
    if ($row['img'] == "") {
        $imgurl = "placeholder.jpg";
    } else {
        $imgurl = $row['img'];
    }

echo "<div class='product-row'>";
echo "
<div class='product-col'>
    <div class='img-thumb' style='background-image: url(../images/products/".$imgurl.");'></div>
</div>
<div class='product-col'>".$row['name']."</div>
<div class='product-col'>".$row['artnr']."</div>
<div class='product-col'>".$row["cat_name"]."</div>
<div class='product-col'>".$row['price']." €</div>
<div class='product-col actions'>
<a><a href='../index.php?page=product&product=show&id=".$row['id']."' target='_blank'><i class='fa fa-eye' aria-hidden='true'></i></a></span>
<span><a href='index.php?page=product&action=edit&id=".$row['id']."'><i class='fa fa-pencil' aria-hidden='true'></i></a></span>
<span><i class='fa fa-trash' aria-hidden='true'></i></span>
</div>
";
echo "</div>";
}
