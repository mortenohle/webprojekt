<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 09.12.17
 * Time: 17:44
 */

include_once('db/connect.php');

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$street = $_POST["street"];
$postcode = $_POST["postcode"];
$city = $_POST["city"];
$email = $_POST["email"];
$city = $_POST["phone"];

try {
    $statement = $con->prepare('UPDATE user SET address = :street, postcode = :postcode, city = :city WHERE user.id = :userid');
    $statement->bindParam(':street', $street);
    $statement->bindParam(':postcode', $postcode);
    $statement->bindParam(':city', $city);
    $statement->bindParam(':userid', $_SESSION["userid"]);
    $statement->execute();

    $cart_items = $_SESSION["cart"];
    $json_cart = json_encode($cart_items);

    $address = $firstname." ".$lastname."<br>".$street."<br>".$postcode." ".$city;


    $statement2 = $con->prepare("INSERT INTO orders (id, products, address, user_id) VALUES (:id, :products, :address, :userid)");
    $null = null;
    $statement2->bindParam(':id', $null, PDO::PARAM_NULL);
    $statement2->bindParam(':products', $json_cart, PDO::PARAM_STR);
    $statement2->bindParam(':address', $address, PDO::PARAM_STR);
    $statement2->bindParam(':userid', $_SESSION["userid"], PDO::PARAM_INT);
    $statement2->execute();
} catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}

$_SESSION["cart"] = array();

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

}
?>


