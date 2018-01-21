<?php
$id = $_GET['id'];
include_once('db/connect.php');

$sql = "SELECT * FROM products WHERE id = ".$id;
$prod = $con->query($sql);
$result = $prod->fetch();
//placeholder abfrage
if (!empty($result['img'])) {
    $imgurl = $result['img'];}
else {
    $imgurl = "placeholder.jpg";
}
if (isset($_POST["product"])) {
    include "cart/addtocart.php";

    echo "<span>Das Produkt wurde zum Warenkorb hinzugefügt. <a href='index.php?page=cart&cart=show'>Zum Warenkorb</a> </span>";
}
?>
<div class="col2">
    <div class="box">
      <img class="prod_image" src="images/products/<?php echo $imgurl; ?>">
    </div>
    <div class='box'>
        <div class="prod_right">
            <span class="prod_title"><?php echo $result["name"]; ?></span><br>
            <span class="prod_price"><?php echo $result["price"]; ?> €</span><br>
            <span class="prod_desc"><?php echo $result["desc"]; ?></span><br>

            <div class="prod_addtocart">

                <form action="" method="post">
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


            </div>
            </div>


        </div>

    </div>


</div>