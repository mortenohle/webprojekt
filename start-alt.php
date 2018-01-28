<?php
include_once('../db/connect.php');
$orderId = $_GET['orderId'];
if (!isset($orderId)) $orderId = 1;
$sql_products = "SELECT orders.*, products.*, orders_products.quantity, categories.name as cat_name
FROM orders, products, orders_products, categories
WHERE orders_products.idorder = orders.id
AND orders_products.idproduct = products.id
AND products.category_id = categories.id
AND orders.id = $orderId";

$query = $con->query($sql_products);
?>
<h1>Dashboard</h1>

<div class="row-2-col">
    <div class="col">
        <h2>Aktuelle Bestellugen</h2>
        <ul>
            <?php  $order_query = $con->query("SELECT * FROM orders WHERE id = $orderId");
            $order = $order_query->fetchObject();?>
            <li><?php echo "Order Id: $orderId" ?></li>
            <li><?php echo "Order Address: ".$order->address ?></li>
            <li><?php echo "Order User id: ". $order->user_id ?></li>
        </ul>

    </div>
    <div class="col">
        <h2>Neu im Sortiment</h2>
        <div class="dashboard-product-container">

            <?php
            foreach ($query as $row_product) {

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
                <div class='d-col product-info'><span class='product-heading'>".$row_product['name']." - ". $row_product['quantity'] ."</span><span class='product-category'>Kategorie: ".$row_product['cat_name']."</span></div>
                <div class='d-col product-price'>".$row_product['price']." €</div>
                ";
                echo "</div>";
            }
            ?>

        </div>
        <a class="btn-link" href="index.php?page=product&action=show">Alle Produkte anzeigen</a>
    </div>
</div>
