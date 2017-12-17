<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 03.12.17
 * Time: 22:52
 */



include_once('db/connect.php');


$total = 0;

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
<div class="checkout">
<h1>Kasse</h1>
<form action='index.php?page=cart&cart=processorder' method="post">

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
    <input type='text' name='firstname' placeholder="Vorname">
        </p>
        <p class="form-row-right">
    <input type='text' name='lastname' placeholder="Name">
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
            echo "
    
 <tr>
    <td>
        <div class='checkout_pleft'>
            <img class='cart_image' src='images/products/".$imgurl."' alt='product placeholder'>
        </div>
        <div class='checkout_pright'>
           <span class=\"cart_desc vertical_align_middle \">".$row['name']."<br>Menge: ".$loopqty."</span>
        </div>


    </td>
    <td><span class=\"cart_price vertical_align_middle \">".$row['price'] * $loopqty." €</span></td>
  </tr>
  ";
            //Gesamtsumme berechnen
            $total += $row['price'] * $loopqty;

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
    <input type='submit' value='kostenpflichtig Bestellen' name='checkout'>

</form>

</div>