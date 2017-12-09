<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 03.12.17
 * Time: 22:52
 */



include_once('db/connect.php');

$test_cart = array(1 => 2);
$cart_items = $test_cart;
$total = 0;
// $cart_items = $_SESSION["cart"];

$cart_count = count($cart_items);
$cart_ids = "";
foreach ($cart_items  AS $prod_id => $prod_qty) {

    if ($i == $cart_count - 1) {
        $cart_ids .= "'". $prod_id ."')";
    }
    else {

        $cart_ids .= "'". $prod_id ."', ";
    }
}
// echo"

?>
<div class="checkout">
<h1>Kasse</h1>
<form action='index.php?page=checkout&action=order'>

    <div class="checkout_details">
<h2>Rechnungsdetails</h2>

  <p class="form-row-wide">
      <div class="dropdown-select-wrapper">
    <select class="dropdown-select" id="salutation" name='salutation'>
        <option value='Herr'>Herr</option>
        <option value='Frau'>Frau</option>
    </select>
        </div>
      </p>
        <p class="form-row-left">
    <input type='text' name='forename' placeholder="Vorname">
        </p>
        <p class="form-row-right">
    <input type='text' name='name' placeholder="Name">
        </p>
        <p class="form-row-wide">
    <input type='text' name='street' placeholder="Straße und Hausnummer">
        </p>
        <p class="form-row-left">
    <input type='text' name='city' placeholder="Ort">
        </p>
        <p class="form-row-right">
    <input type='text' name='postcode' placeholder="PLZ">
        </p>
        <p class="form-row-left">
    <input type='tel' name='phone' placeholder="Telefon">
        </p>
        <p class="form-row-right">
    <input type='email' name='email' placeholder="Email">
        </p>

        <div style="clear: both"></div>
    </div>

    <div class="checkout_payment">
    <h2>Zahlungsart wählen</h2>

    <fieldset>
        <input type='radio' id='kk' name='payment' value='kreditkarte'>
        <label for='kk'>Kreditkarte</label>
        <input type='radio' id='paypal' name='payment' value='paypal'>
        <label for='paypal'>PayPal</label>
        <input type='radio' id='bank' name='payment' value='bank'>
        <label for='bank'>Überweisung</label>
    </fieldset>
    </div>

    <div class="checkout_summary">
    <h2>Zusammenfassung</h2>

    <table style="width:100%">
        <tr>
            <th>Produkt</th>
            <th>Gesamtsumme</th>
        </tr>
        <?php
        $sql_for_cart = "SELECT * FROM products WHERE id IN (".$cart_ids;
        foreach ($con->query($sql_for_cart) as $row) {
            if (!empty($row['img'])) {
                $imgurl = $row['img'];}
            else {
                $imgurl = "placeholder.jpg";
            }
            $totalprice += $row['price'] * $cart_items[$row['id']];
            echo "
    
 <tr>
    <td>
        <div class='checkout_pleft'>
            <img class='cart_image' src='images/products/".$imgurl."' alt='product placeholder'>
        </div>
        <div class='checkout_pright'>
           <span class=\"cart_desc vertical_align_middle \">".$row['name']."<br>Menge: ".$cart_items[$row['id']]."</span>
        </div>


    </td>
    <td><span class=\"cart_price vertical_align_middle \">".$row['price'] * $cart_items[$row['id']]." €</span></td>
  </tr>
  ";
            //Gesamtsumme berechnen
            $total += $row['price'] * $cart_items[$row['id']];

        } ?>
        <tr>
            <td>Zwischensumme</td>
            <td><?php echo $total; ?> €</td>
        </tr>
        <tr>
            <td>Versandkosten</td>
            <td>Kostenlos</td>
        </tr>
        <tr>
            <td>Gesamtsumme</td>
            <td><?php echo $total; ?> €</td>
        </tr>
    </table>

    </div>
    <input class='cart_update' type='submit' value='Kasse' name='checkout'>

</form>

</div>