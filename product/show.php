<?php
$id = $_GET['id'];
include_once('db/connect.php');

$sql = "SELECT * FROM products WHERE id = ".$id;
$prod = $con->query($sql);
$result = $prod->fetch();
//size abfrage
if (isset($_GET["size"])) {
    $size = $_GET["size"];
} else {$size = "s";}

//placeholder abfrage
if (!empty($result['img'])) {
    $imgurl = $result['img'];}
else {
    $imgurl = "placeholder.jpg";
}
if (isset($_POST["product"])) {
    $cart->addtocart($_POST["product"],$_POST["quantity"],$_POST["size"]);
}
?>
<div class="col2 single-product-page">
    <div class="box">
      <img class="prod_image" src="images/products/<?php echo $imgurl; ?>">
    </div>
    <div class='box'>
        <div class="prod_right">
            <span class="prod_title"><?php echo $result["name"]; ?></span><br>
            <span class="prod_price"><?php echo $result["price"]; ?> €</span><br>
            <span class="prod_desc"><?php echo $result["desc"]; ?></span><br>
            <?php
            // Abfrage des Lagerstatus
            $lager = $stock->howmany($result["id"], $size);

            if ($lager < 1) {
                echo "Größe ".strtoupper($size)." ist derzeit ausverkauft.";
            }
            if ($lager <= 10 && $lager > 1) {
                echo "In Größe ".strtoupper($size)." sind noch ".$lager." auf Lager.";
            }
            if ($lager > 10) {
                echo "Größe ".strtoupper($size)." ist auf Lager.";
            }

            ?>

            <div class="prod_addtocart">

                <form action="" method="post">
                    <div class="dropdown-select-wrapper size-select">
                        <select id="sizeis" class="dropdown-select" id="size" name='size'>
                            <option value='s' <?php if($size == "s") {echo "selected";} ?>>S</option>
                            <option value='m' <?php if($size == "m") {echo "selected";} ?>>M</option>
                            <option value='l' <?php if($size == "l") {echo "selected";} ?>>L</option>
                            <option value='xl' <?php if($size == "xl") {echo "selected";} ?>>XL</option>
                        </select>
                    </div>
                    <input class="quantity" type="number" name="quantity" min="1" max="9" step="1" value="1">
                    <input type="hidden" name="product" value="<?php echo $result["id"]; ?>">
                    <input class="addtocart_button" type="submit" value="In den Einkaufswagen">
                </form>

            </div>
<?php
//Kategorien Abfrage
$sql2 = "SELECT * FROM categories WHERE id = ".$result["category_id"];
$cat = $con->query($sql2);
$result2 = $cat->fetch();
?>
            <div class="prod_categories">
                <span><b>Kategorie:</b> <a href="index.php?page=category&category=<?php echo $result2["id"]; ?>"><?php echo $result2["name"]; ?></a></span>
                <br><span class="single-product-ean"><b>EAN-Code:</b> <?php echo $result["ean"]; ?></span>
            </div>
            </div>


        </div>

    </div>


</div>

<div class="spp-tabs">
    <div class="inner-wrapper">
        <div id="spp-tab-container">

            <input id="tab1" type="radio" name="tabs" checked>
            <label for="tab1">Beschreibung</label>

            <?php
            $sql_count = "SELECT COUNT(*) c FROM rating WHERE produkt_id = " . $id;
            $result_count = $con->query($sql_count);
            $count = $result_count->fetch(PDO::FETCH_ASSOC);
            ?>

            <input id="tab2" type="radio" name="tabs">
            <label for="tab2">Bewertungen (<?php echo $count["c"]; ?>)</label>

            <section id="content1">
                <div class="tab-inner-section">
                    <p><?php echo $result["desc"]; ?></p>
                </div>
            </section>

            <section id="content2">
                <div class="tab-inner-section">

                    <?php
                    if(isset($_SESSION["username"])) {

                        if ($count["c"] == 0) {
                            echo "
                                <p>Für dieses Produkt gibt es noch keine Bewertung. Sei der Erste!</p>
                                <a class='btn-link' href='index.php?page=product&product=rate&id=" . $id . "'>Produkt bewerten!</a>";
                        } else {
                            $sql_rating = "SELECT rating.*, `user`.firstname AS firstname FROM rating, `user` WHERE rating.produkt_id =".$id." GROUP BY rating.id";

                            foreach ($con->query($sql_rating) as $row) {
                                $date_german = date('d.m.Y', strtotime($row['date']));
                                echo "
                                    <div class='rating-result'>
                                    <span class='rating-user'>".$row['firstname']."</span>
                                    <span class='rating-date'>".$date_german."</span>
                                    <span class='rating-text'>".$row['kommentar']."</span>
                                    <div class='rating-4-col'>
                                        <div class='rating-col'>
                                            <b>Qualität:</b> ".$row['qualitaet']."
                                        </div>
                                        <div class='rating-col'>
                                            <b>Versand:</b> ".$row['versand']."
                                        </div>
                                        <div class='rating-col'>
                                            <b>Passform:</b> ".$row['passform']."
                                        </div>
                                        <div class='rating-col'>
                                            <b>Preis-/Leistung:</b> ".$row['leistung']."
                                        </div>
                                    </div>
                                    </div>
                                    ";

                            }

                            echo "<p>Wie gefällt dir das Produkt? Schreibe eine Bewertung!</p>
                                <a class='btn-link' href='index.php?page=product&product=rate&id=" . $id . "'>Produkt bewerten!</a>";

                        }
                    } else {
                        if ($count["c"] == 0) {
                            echo "
                                <p>Für dieses Produkt gibt es noch keine Bewertung. Melde dich an und sei der Erste!</p>
                                <a class='btn-link' href='index.php?page=account&action=login'>Zur Anmeldung!</a>";
                        } else {

                            $sql_rating = "SELECT rating.*, `user`.firstname AS firstname FROM rating, `user` WHERE rating.produkt_id =".$id." GROUP BY rating.id";

                            foreach ($con->query($sql_rating) as $row) {
                                $date_german = date('d.m.Y', strtotime($row['date']));
                                echo "
                                    <div class='rating-result'>
                                    <span class='rating-user'>".$row['firstname']."</span>
                                    <span class='rating-date'>".$date_german."</span>
                                    <span class='rating-text'>".$row['kommentar']."</span>
                                    <div class='rating-4-col'>
                                        <div class='rating-col'>
                                            <b>Qualität:</b> ".$row['qualitaet']."
                                        </div>
                                        <div class='rating-col'>
                                            <b>Versand:</b> ".$row['versand']."
                                        </div>
                                        <div class='rating-col'>
                                            <b>Passform:</b> ".$row['passform']."
                                        </div>
                                        <div class='rating-col'>
                                            <b>Preis-/Leistung:</b> ".$row['leistung']."
                                        </div>
                                    </div>
                                    </div>
                                    ";

                            }

                            echo "
                                <p>Melde dich an, um eine Bewertung zu schreiben!</p>
                                <a class='btn-link' href='index.php?page=account&action=login'>Zur Anmeldung!</a>";
                        }
                    }
                    ?>

                </div>
            </section>


        </div>
    </div>
</div>