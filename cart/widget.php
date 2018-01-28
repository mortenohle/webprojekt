<div class="cart_widget_wrapper">
<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 22.01.18
 * Time: 10:24
 */

include_once('db/connect.php');

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

$i = 0;
$sql_for_cart = "SELECT * FROM products WHERE id IN (".$cart_ids.")";
foreach ($con->query($sql_for_cart) as $row) {
    $id = $row['id'];

    foreach($_SESSION["cart"] as $subkey => $subarray){
        if($subarray["product_id"] == $id){
            $loopqty = ($_SESSION["cart"][$subkey]["quantity"]);
        }
    }
    /* foreach ($_SESSION["cart"] as $b) {
        if ($b["product_id"] == $id) {
            $loopqty = $b["quantity"];
            break;
        }
    }  */
    if (!empty($row['img'])) {
        $imgurl = $row['img'];}
    else {
        $imgurl = "placeholder.jpg";
    }
    $totalprice += $row['price'] * $loopqty;
    echo "
<div class=\"cart_in_widget\">
    <div class=\"cart_widget_img\">
        <img class=\"cart_image\" src='images/products/".$imgurl."' alt='product placeholder' style=\"
    width: 40px !important;
    bottom: 0px !important;
    position: inherit;
\">
    </div>
    <div class=\"cart_widget_dsc\">
        <span class=\"cart_desc \">".$row['name']."</span>
    </div>
    <div class=\"cart_widget_price\">
        <span class=\"cart_price \">".$row['price'] * $loopqty ." €</span>
    </div>
    </div>
     ";

    $i++;
}
?>
<div class='cart_widget_footer'>
    <a class='cart_widget_link btn-link btn-small' href='#'>Warenkorb</a>
    <a class='cart_widget_link btn-link btn-small' href='#'>Kasse</a>
</div>
</div>