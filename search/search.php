<?php
include_once('db/connect.php');

$searchterm = $_GET["searchterm"];
$query = "";
$searchterm = explode (" ", $searchterm);

for ($i = 0; $i < sizeof($searchterm); $i++) {
    $query .= "`name` LIKE '%" . $searchterm[$i] . "%'";

    if($i < (sizeof($searchterm) - 1)) {
        $query .= "OR";
    }
}

$sql_count = "SELECT COUNT(*) c FROM products WHERE " . $query;
$result = $con->query($sql_count);
$count = $result->fetch(PDO::FETCH_ASSOC);

$product_count = $count["c"];

?>
<h1>Suchergebnis</h1>

<?php

if ($product_count == 0) {
    echo "<p>Wir haben leider kein Produkt gefunden, das deinem Suchwort entspricht!</p>
    <a class='btn-link' href='index.php' style='margin-top: 30px;'>Zur Startseite</a>
    ";

} else {

    if ($product_count == 1) {
        echo "<p>Wir haben <b>ein</b> Produkt für dich gefunden!</p>";
    } else {
        echo "<p>Wir haben <b>" . $product_count . "</b> Produkte für dich gefunden!</p>";
    }

    echo "<div class='pwrapper'>";

    $sql = "SELECT * FROM products WHERE " . $query;

    foreach ($con->query($sql) as $row) {

        //placeholder abfrage
        if (!empty($row['img'])) {
            $imgurl = $row['img'];
        } else {
            $imgurl = "placeholder.jpg";
        }

        echo "<div class='box'>";
        echo "<div class='imagebox'><img class='pplaceholder' src='images/products/" . $imgurl . "' alt='product placeholder'>
    <div class='imageoverlay'>
    <div class='overlaycontent'><a href='index.php?page=product&product=show&id=" . $row['id'] . "'>Details</a></div>
    </div></div>";
        echo "<div class='pdesc'><a class='ptitle' href='index.php?page=product&product=show&id=" . $row['id'] . "'>" . $row['name'] . "</a><br><span class='pprice'>" . $row['price'] . " €</span></div>";
        echo "</div>";
    }

    echo "</div>";
}

?>