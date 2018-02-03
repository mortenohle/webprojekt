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

            <input id="tab2" type="radio" name="tabs">
            <label for="tab2">Bewertungen</label>

            <section id="content1">
                <div class="tab-inner-section">
                    <p><?php echo $result["desc"]; ?></p>
                </div>
            </section>

            <section id="content2">
                <div class="tab-inner-section">
                    Kundenbewertung
                </div>
            </section>


        </div>
    </div>
</div>