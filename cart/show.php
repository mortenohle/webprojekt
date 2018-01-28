<?php
/**
 * Created by PhpStorm.
 * User: Morten
 * Date: 06.11.17
 * Time: 12:02
 */
if($_POST["update"]) {
    $newcart = $_POST["qty"];
    $cart->updateall($newcart);
}
if($_POST["coupon"]) {

    echo "Aktuell ist die Gutschein Funktion inaktiv.";

}

if (empty($_SESSION["cart"]) || !isset($_SESSION["cart"])) {
    echo '<div class="error_dialog"> <span class="error_message">Dein Warenkorb ist leer.</span><br>
<a class="btn-link" href="index.php">Zurück zum Shop</a></div>';
} else {
$cart_items = $_SESSION["cart"];

$cart_count = count($cart_items);
$cart_ids = "";
$i = 0;
foreach ($cart_items  AS $prod_id) {
    if ($i == $cart_count - 1) {
        $cart_ids .= $prod_id["product_id"];
    }
    else {
        $cart_ids .= $prod_id["product_id"] .",";
        $i++;
    }
}
?>
<form action="index.php?page=cart&cart=show" method="post">
<div class="cartbox">

    <div class="cart_header">

    <div class="box">
        <span class="cartlabel">Löschen</span>
    </div>
    <div class="box">
    <span class="cartlabel">Bild</span>
    </div>
    <div class="box">
        <span class="cartlabel">Beschreibung</span>
    </div>
    <div class="box">
        <span class="cartlabel">Preis</span>
    </div>
    <div class="box">
        <span class="cartlabel">Menge</span>
    </div>
    <div class="box">
        <span class="cartlabel">Gesamt</span>
    </div>
    </div>
<?php
$i = 0;
$sql_for_cart = "SELECT * FROM products WHERE id IN (".$cart_ids.")";
foreach ($con->query($sql_for_cart) as $row) {
    $id = $row['id'];

    foreach($_SESSION["cart"] as $subkey => $subarray){
        if($subarray["product_id"] == $id){
            $loopqty = ($_SESSION["cart"][$subkey]["quantity"]);
        }
    }
    if (!empty($row['img'])) {
        $imgurl = $row['img'];}
    else {
        $imgurl = "placeholder.jpg";
    }
    $totalprice += $row['price'] * $loopqty;
    echo "
    <div class=\"cart_row\">
    <div class=\"box\">
        <a href='index.php?page=cart&cart=delete&id=".$row['id']."' class=\"cart_delete vertical_align_middle\">X</a>
    </div>
    <div class=\"box\">
        <img class=\"cart_image\" src='images/products/".$imgurl."' alt='product placeholder'>
    </div>
    <div class=\"box\">
        <span class=\"cart_desc vertical_align_middle \">".$row['name']."</span>
    </div>
    <div class=\"box\">
        <span class=\"cart_price vertical_align_middle \">".$row['price']." €</span>
    </div>
    <div class=\"box\">
   <input type='hidden' name='qty[".$i."][product_id]' value='".$row['id']."'>
           <input class=\"quantity vertical_align_middle \" type=\"number\" name=\"qty[".$i."][quantity]\" min=\"1\" max=\"9\" step=\"1\" value=\"".$loopqty."\">
    </div>
    <div class=\"box\">
        <span class=\"cart_price vertical_align_middle \">".$row['price'] * $loopqty ." €</span>
    </div>
    </div>";

    $i++;
}
?>

    <div class="cart_footer">
        <div class="box">
        <input class="coupon_code cart_coupon" type="text" name="coupon_code" placeholder="Code eingeben">
        <input class="cart_coupon" type="submit" value="Einlösen" name="coupon">
        </div>
        <div class="box">
        <input class="cart_update" type="submit" value="Aktualisieren" name="update" />
        </div>
    </div>
</div>

    <div class="cart_summary">
<h2>Warenkorb Summe</h2>
<div class="summary_table">
    Gesamtpreis: <?php echo $totalprice; ?> €
</div>
<a class="btn-link tocheckout" style="width: 150px;" href="index.php?page=cart&cart=checkout">Zur Kasse</a>
</div>
    <div class="clearfloat"></div>

</form>

<?php }?>