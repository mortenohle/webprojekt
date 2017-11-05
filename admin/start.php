<?php
include_once('../db/connect.php');
$sql_products = "SELECT products.*, categories.name AS cat_name FROM products JOIN categories ON products.category_id = categories.id ORDER BY id DESC";
?>
<h1>Dashboard</h1>

<div class="row-2-col">
    <div class="col">
        <h2>Aktuelle Bestellugen</h2>
    </div>
    <div class="col">
        <h2>Neu im Sortiment</h2>
        <div class="dashboard-product-container">

            <?php
            foreach ($con->query($sql_products) as $row_product) {

                // Abfrage Produktbild
                if ($row_product['img'] == "") {
                    $imgurl = "placeholder.jpg";
                } else {
                    $imgurl = $row_product['img'];
                }

                echo "<div class='row'>";
                echo "
                <div class='d-col product-image'>
                    <div class='img-thumb' style='background-image: url(../images/products/".$imgurl.");'></div>
                </div>
                <div class='d-col product-info'><span class='product-heading'>".$row_product['name']."</span><span class='product-category'>Kategorie: ".$row_product['cat_name']."</span></div>
                <div class='d-col product-price'>".$row_product['price']." €</div>
                ";
                echo "</div>";
            }
            ?>

        </div>
        <a class="btn-link" href="index.php?page=product&action=show">Alle Produkte anzeigen</a>
    </div>
</div>