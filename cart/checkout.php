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

if (isset($_SESSION["userid"])) {
    $statement = $con->prepare('SELECT * FROM user WHERE id = :userid');
    $statement->bindParam(':userid', $_SESSION["userid"]);
    $statement->execute();
    $result = $statement->fetch();
}

?>
<div class="checkout">
<h1>Kasse</h1>
<form action='index.php?page=cart&cart=processorder' method="post">

    <div class="checkout_details">
<h2>Rechnungsdetails</h2>
<div class="checkout-form">
  <p class="form-row-wide">
      <div class="dropdown-select-wrapper">
    <select class="dropdown-select" id="salutation" name='salutation'>
        <option value='Herr'>Herr</option>
        <option value='Frau'>Frau</option>
    </select>
        </div>
      </p>
        <p class="form-row-left">
    <input type='text' name='firstname' placeholder="Vorname" value="<?php echo $result["firstname"] ?>" required>
        </p>
        <p class="form-row-right">
    <input type='text' name='lastname' placeholder="Name" value="<?php echo $result["lastname"] ?>" required>
        </p>
        <p class="form-row-wide">
    <input type='text' name='street' placeholder="Straße und Hausnummer" value="<?php echo $result["address"] ?>" required>
        </p>
        <p class="form-row-left">
    <input type='text' name='city' placeholder="Ort" value="<?php echo $result["city"] ?>" required>
        </p>
        <p class="form-row-right">
    <input type='text' name='postcode' placeholder="PLZ" value="<?php echo $result["postcode"] ?>" required>
        </p>
        <p class="form-row-left">
    <input type='tel' name='phone' placeholder="Telefon" required>
        </p>
        <p class="form-row-right">
    <input type='email' name='email' placeholder="Email" value="<?php echo $result["email"] ?>" <?php if (isset($result["email"])) {echo "readonly";}?> required>
        </p>

        <div style="clear: both"></div>
    </div>
    </div>

    <div class="checkout_payment">
    <h2>Zahlungsart wählen</h2>

    <fieldset>
        <input type='radio' id='kk' name='payment' value='kreditkarte'>
        <label for='kk'>Kreditkarte</label>
        <input type='radio' id='paypal' name='payment' value='paypal'>
        <label for='paypal'>PayPal</label>
        <input type='radio' id='bank' name='payment' value='bank' checked>
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
           <span class=\"cart_desc\">".$row['name']."<br>Menge: ".$loopqty."</span>
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
        <div class="agb-check">
        <input id="checkbox-agb" type="checkbox" name="agbs" required>
        <label for="checkbox-agb">
            Mit deiner Bestellung erklärst du dich mit unseren <a href="index.php?page=legal&legal=agb">Allgemeinen Geschäftsbedingungen</a> und <a href="index.php?page=legal&legal=widerruf">Widerrufsbestimmungen</a> einverstanden.
        </label>
        </div>
    </div>

    <input style="float: right;" type='submit' value='kostenpflichtig Bestellen' name='checkout'>
    <div class="clearfloat"></div>

</form>

</div>