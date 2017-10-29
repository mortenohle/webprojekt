<h1>Produkte</h1>

<div class="row-full-width">
    <a class="btn-link" href="index.php?page=product&action=new">Produkt hinzufügen</a>

    <div class="product-category-row">
        <ul class="poduct-category">
            <li>Alle <span class="item-count">()</span></li>
            <li>Shirts <span class="item-count">()</span></li>
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
include_once('../db/connect.php');

$sql = "SELECT * FROM products ORDER BY id ASC";

foreach ($con->query($sql) as $row) {
echo "<div class='product-row'>";
echo "
<div class='product-col'>
    <div class='img-thumb'></div>
</div>
<div class='product-col'>".$row['name']."</div>
<div class='product-col'>".$row['artnr']."</div>
<div class='product-col'>".$row['categories']."</div>
<div class='product-col'>".$row['price']." €</div>
<div class='product-col actions'>
<span><i class='fa fa-eye' aria-hidden='true'></i></span>
<span><i class='fa fa-pencil' aria-hidden='true'></i></span>
<span><i class='fa fa-trash' aria-hidden='true'></i></span>
</div>
";
echo "</div>";
}
?>