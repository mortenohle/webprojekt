<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 09.12.17
 * Time: 17:44
 */

$error = "false";

if (strlen($_POST["firstname"]) < 2) {
    $error = "true";
    echo "Bitte gebe deinen Vornamen ein <br>";
}
if (strlen($_POST["lastname"]) < 2) {
    $error = "true";
    echo "Bitte gebe deinen Nachnamen ein <br>";
}
if (strlen($_POST["street"]) < 2) {
    $error = "true";
    echo "Bitte gebe eine Straße ein <br>";
}
if (strlen($_POST["postcode"]) < 2) {
    $error = "true";
    echo "Bitte gebe eine Postleitzahl ein <br>";
}
if (strlen($_POST["city"]) < 2) {
    $error = "true";
    echo "Bitte gebe eine Stadt ein <br>";
}
if (strlen($_POST["email"]) < 2) {
    $error = "true";
    echo "Bitte gebe eine Email ein <br>";
}
if ($error == "true") {
echo "<a style='margin-top: 10px;' class=\"btn-link\" href=\"index.php?page=cart&cart=checkout\">Zurück</a>";
}

echo "Werte: <br>";
echo $_POST["firstname"]."<br>";
echo $_POST["lastname"]."<br>";;
echo $_POST["street"]."<br>";;
echo $_POST["postcode"]."<br>";;
echo $_POST["city"]."<br>";;
echo $_POST["email"]."<br>";;
echo $_POST["phone"]."<br>";;

if ($error == "false") {

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $street = $_POST["street"];
    $postcode = $_POST["postcode"];
    $city = $_POST["city"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

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
        //echo "id: ".$value["product_id"];
        $sql_for_price = "SELECT * FROM products WHERE id = ".$value["product_id"];
        $pricing = $con->query($sql_for_price);
        $priceresult = $pricing->fetch();

        //echo $priceresult["price"];
        $_SESSION["cart"][$key]["price"] = $priceresult["price"];
    }
    print_r($_SESSION["cart"]);
    echo "<br>";

    $cart_items = $_SESSION["cart"];
    $json_cart = json_encode($cart_items);

    echo $json_cart."<br>";;

    $address = $firstname . " " . $lastname . "<br>" . $street . "<br>" . $postcode . " " . $city;


            $statement2 = $con->prepare("INSERT INTO orders (id, products, address, user_id) VALUES (:id, :products, :address, :userid)");
            $null = null;
            $statement2->bindParam(':id', $null, PDO::PARAM_NULL);
            $statement2->bindParam(':products', $json_cart, PDO::PARAM_STR);
            $statement2->bindParam(':address', $address, PDO::PARAM_STR);
            $statement2->bindParam(':userid', $user_id, PDO::PARAM_INT);
            $statement2->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    ?>

    <h1>Danke für deine Bestellung</h1>
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

    } ?>

    <div class="checkout_summary">
        <h2>Zusammenfassung</h2>

        <table style="width:100%">
            <tr>
                <th>Produkt</th>
                <th>Gesamtsumme</th>
            </tr>
            <?php
            $sql_for_cart = "SELECT * FROM products WHERE id IN (" . $cart_ids . ")";
            foreach ($con->query($sql_for_cart) as $row) {
                $id = $row['id'];
                foreach ($_SESSION["cart"] as $subkey => $subarray) {
                    if ($subarray["product_id"] == $id) {
                        $loopqty = ($_SESSION["cart"][$subkey]["quantity"]);
                    }
                }
                if (!empty($row['img'])) {
                    $imgurl = $row['img'];
                } else {
                    $imgurl = "placeholder.jpg";
                }
                echo "
    
 <tr>
    <td>
        <div class='checkout_pleft'>
            <img class='cart_image' src='images/products/" . $imgurl . "' alt='product placeholder'>
        </div>
        <div class='checkout_pright'>
           <span class=\"cart_desc vertical_align_middle \">" . $row['name'] . "<br>Menge: " . $loopqty . "</span>
        </div>


    </td>
    <td><span class=\"cart_price vertical_align_middle \">" . $row['price'] * $loopqty . " €</span></td>
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

    <?php unset($_SESSION["cart"]);

}
 ?>
