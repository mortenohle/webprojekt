<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 09.12.17
 * Time: 17:44
 */

$error = false;
if (!isset($_POST['agbs'])) {
    $error = true;
    echo "Bitte bestätige unsere AGB und Widerrufsbelehrung <br>";
}
if (strlen($_POST["firstname"]) < 2) {
    $error = true;
    echo "Bitte gebe deinen Vornamen ein <br>";
}
if (strlen($_POST["lastname"]) < 2) {
    $error = true;
    echo "Bitte gebe deinen Nachnamen ein <br>";
}
if (strlen($_POST["street"]) < 2) {
    $error = true;
    echo "Bitte gebe eine Straße ein <br>";
}
if (strlen($_POST["postcode"]) < 2) {
    $error = true;
    echo "Bitte gebe eine Postleitzahl ein <br>";
}
if (strlen($_POST["city"]) < 2) {
    $error = true;
    echo "Bitte gebe eine Stadt ein <br>";
}
if (strlen($_POST["email"]) < 2) {
    $error = true;
    echo "Bitte gebe eine Email ein <br>";
}
if ($error == true) {
    echo "<a style='margin-top: 10px;' class=\"btn-link\" href=\"index.php?page=cart&cart=checkout\">Zurück</a>";
}
if (!$error) {

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $street = $_POST["street"];
    $postcode = $_POST["postcode"];
    $city = $_POST["city"];
    $email = $_POST["email"];

    if (!isset($_SESSION["userid"])) {
        $user_id = 0;
    } else { $user_id = $_SESSION["userid"];}
    $total = 0;

    $cart_items = $_SESSION["cart"];

    $cart_count = count($cart_items);
    $cart_ids = "";
    $i = 0;
    foreach ($cart_items AS $prod_id) {
        if ($i == $cart_count - 1) {
            $cart_ids .= $prod_id["product_id"];
        } else {
            $cart_ids .= $prod_id["product_id"] . ",";
            $i++;
        }
    }

    try {

        //Benutzer Adresse updaten
        if (isset($_SESSION["userid"])) {
            $statement = $con->prepare('UPDATE user SET address = :street, postcode = :postcode, city = :city WHERE user.id = :userid');
            $statement->bindParam(':street', $street);
            $statement->bindParam(':postcode', $postcode);
            $statement->bindParam(':city', $city);
            $statement->bindParam(':userid', $_SESSION["userid"]);
            $statement->execute();
        }


        //aktuellen Preis einfügen

        foreach ($_SESSION["cart"] as $key => $value) {
            $sql_for_price = "SELECT * FROM products WHERE id = " . $value["product_id"];
            $pricing = $con->query($sql_for_price);
            $priceresult = $pricing->fetch();
            $_SESSION["cart"][$key]["price"] = $priceresult["price"];
        }

        $cart_items = $_SESSION["cart"];
        $json_cart = json_encode($cart_items);

        $address = $firstname . " " . $lastname . "<br>" . $street . "<br>" . $postcode . " " . $city;

        //order in DB Schreiben
        $statement2 = $con->prepare("INSERT INTO orders (id, products, address, user_id) VALUES (:id, :products, :address, :userid)");
        $null = null;
        $statement2->bindParam(':id', $null, PDO::PARAM_NULL);
        $statement2->bindParam(':products', $json_cart, PDO::PARAM_STR);
        $statement2->bindParam(':address', $address, PDO::PARAM_STR);
        $statement2->bindParam(':userid', $user_id, PDO::PARAM_INT);
        $statement2->execute();

        //Bestellnummer holen
        $orderid = $con->lastInsertId();
        //Lagerbestand reduzieren
        foreach ($_SESSION["cart"] as $subkey => $subarray) {
            $id = $subarray["product_id"];
            $stock->reducestock($subarray["product_id"],$subarray["quantity"],$subarray["size"]);
        }
        //Email Bestätigung an Kunden senden

        // Tabelle für Email generieren
        $ordertablebody = "";
        $totalprice2 = 0;
        foreach ($_SESSION["cart"] as $subkey => $subarray) {

            $id = $subarray["product_id"];
            $statement = $con->prepare("SELECT * FROM products WHERE id = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
            $result2 = $statement->fetch();

            $totalprice2 += $result2['price'] * $subarray["quantity"];

            $ordertablebody .= "<tr>
        <td>".$result2['name']."<br>Größe: ".strtoupper($subarray["size"])."</td>
        <td>".$subarray["quantity"]."</td>
        <td>".$result2['price'] * $subarray["quantity"] ." €</td>
    </tr>";
        }
        $ordertable = "<table>
        <tr>
            <th>Produkt</th>
            <th>Menge</th>
            <th>Preis</th>
        </tr>".$ordertablebody."    <tr>
            <td><b>Gesamtpreis</b></td>
            <td> </td>
            <td><b>".$totalprice2." €</b></td>
        </tr>
    </table>";
$subject = "Deine Bestellung #".$orderid." bei LOGO";
$content = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    <title>Deine Bestellung im LOGO Shop</title>
</head><h1>Danke für deine Bestellung bei LOGO.</h1><br>
<p>Bestellnummer: #".$orderid."</p><br>
<p>Hallo ".$firstname." ".$lastname.",<br>
danke für deine Bestellung bei Logo. Nachfolgend siehst du alle Details zu deiner Bestellung.</p><br>".$ordertable."
<p>Versandkosten: kostenlos<br>
Zahlungsmethode: ".$_POST["payment"]."</p>

<h2>Dein LOGO Store</h2>
<p>
<a style='margin-top: 10px;' href='https://mars.iuk.hdm-stuttgart.de/~mo043/index.php?page=legal&legal=impressum\'>Impressum</a>
<a style='margin-top: 10px;' href='https://mars.iuk.hdm-stuttgart.de/~mo043/index.php?page=legal&legal=agb\'>AGB</a>
<a style='margin-top: 10px;' href='https://mars.iuk.hdm-stuttgart.de/~mo043/index.php?page=legal&legal=widerruf\'>Widerrufsbelehrung</a>
</p>";

$absender = "From:LOGO Shop <info@logoshop.de>";
mail($email,$subject,$content,$absender);
    }
    catch
        (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    ?>

    <h1>Danke für deine Bestellung - Nr. <?php echo $orderid; ?></h1>
    <p>Nachfolgend siehst du alle Details zu deiner Bestellung.</p>

    <h2>Adresse</h2>
    <p>Die Liefer- und Rechnungsadresse deiner Bestellung lautet:</p>

    <?php
    echo $address;

    ?>

    <h2>Zahlung</h2>

    <?php
    if ($_POST["payment"] == "bank") {

        echo "<span>Bitte überweise den Rechnungsbetrag auf das Konto</span>";

    } elseif ($_POST["payment"] == "paypal") {

        echo "<span>Klicke hier, um mit PayPal zu bezahlen.</span>";

    } elseif ($_POST["payment"] == "kreditkarte") {

        echo "<span>Klicke hier, um mit Kreditkarte zu bezahlen.</span>";

    }

    $cart->getsummary();

    unset($_SESSION["cart"]);

}
 ?>
