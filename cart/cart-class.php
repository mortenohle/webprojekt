<?php
/**
 * Created by PhpStorm.
 * User: morten
 * Date: 28.01.18
 * Time: 13:06
 */

class cart {

    private $conn;

    public function __construct($con) {
        $this->conn = $con;
    }

    public function check_cart() {
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
    }
    public function addtocart($id, $quantity, $size) {

        $stock = new stockmanagement($this->conn);

        if ($stock->isavaible($id, $quantity, $size)) {

            if (isset($_SESSION["cart"])) {

            $notavaible = true;
            foreach ($_SESSION["cart"] as $subkey => $subarray) {
                if ($subarray["product_id"] == $id && $subarray["size"] == $size) {
                    $_SESSION["cart"][$subkey]["quantity"] += $quantity;
                    $notavaible = false;
                }
            }
            if ($notavaible) {
                $add_to_cart = array("product_id" => $id, "quantity" => $quantity, "size" => $size);
                // $_SESSION["cart"] = array_merge_recursive( (array)$_SESSION["cart"], (array)$add_to_cart );
                array_push($_SESSION["cart"], $add_to_cart);
            }

        } else { $_SESSION["cart"] = array(array("product_id" => $id, "quantity" => $quantity, "size" => $size)); }

            echo $this->notification("<span>Das Produkt wurde zum Warenkorb hinzugefügt. <a href='index.php?page=cart&cart=show'>Zum Warenkorb</a> </span>");

        } else { echo $this->notification("Die gewählte Größe, Menge des Produkts ist leider nciht mehr auf Lager.");}

    }

    public function updateall($newcart) {

        $_SESSION["cart"] = $newcart;


    }
    public function updatesingle($id, $quantity) {

        foreach ($_SESSION["cart"] as $subkey => $subarray) {
            if ($subarray["product_id"] == $id) {
                $_SESSION["cart"][$subkey]["quantity"] += $quantity;
            }
        }
    }

    public function cartcount() {

        $cart_items = $_SESSION["cart"];
        return count($cart_items);
    }

    public function isempty() {

        return $this->cartcount() <= 0;
    }

    public function deleteitem($delete_id, $size) {

        if ($this->cartcount() < 2) { unset($_SESSION["cart"]); $nothing = true; } else {
            foreach($_SESSION["cart"] as $subkey => $subarray){
                if($subarray["product_id"] == $delete_id && $subarray["size"] == $size){
                    unset($_SESSION["cart"][$subkey]);
                }
            }}

        echo $this->notification("Das Produkt wurde erfolgreich entfernt");
        return $nothing;
    }

    public function notification($content) {

        return "
        <div class='notification '>
        ".$content."
        </div>
        ";

    }
    public function getcart() {

        $nothing = false;
        if (isset($_GET["deleteid"])) {
            $this->deleteitem($_GET["deleteid"],$_GET["deletesize"]);
        }
        if($_POST["update"]) {
            $newcart = $_POST["qty"];
            $this->updateall($newcart);
        }
        if($_POST["coupon"]) {

            echo $this->notification("Aktuell ist die Gutschein Funktion inaktiv.");

        }

        $totalprice = 0;
        $i = 0;
        if (isset($_SESSION["cart"]) || !empty($_SESSION["cart"]) || $nothing) {
            ?><form action="index.php?page=cart&cart=show" method="post">
            <div class="cartbox">

                <div class="cart_header">

                    <div class="box">
                        <span class="cartlabel"></span>
                    </div>
                    <div class="box">
                        <span class="cartlabel"></span>
                    </div>
                    <div class="box">
                        <span class="cartlabel">Beschreibung</span>
                    </div>
                    <div class="box pricing">
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
            foreach ($_SESSION["cart"] as $subkey => $subarray) {

                $id = $subarray["product_id"];
                $statement = $this->conn->prepare("SELECT * FROM products WHERE id = :id");
                $statement->bindParam(':id', $id);
                $statement->execute();
                $result2 = $statement->fetch();


                if (!empty($result2['img'])) {
                    $imgurl = $result2['img'];}
                else {
                    $imgurl = "placeholder.jpg";
                }
                $totalprice += $result2['price'] * $subarray["quantity"];
                echo "
        <div class=\"cart_row\">
        <div class=\"box\">
            <a href='index.php?page=cart&cart=show&deleteid=".$subarray["product_id"]."&deletesize=".$subarray["size"]."' class=\"cart_delete vertical_align_middle\">X</a>
        </div>
        <div class=\"box\">
            <img class=\"cart_image\" src='images/products/".$imgurl."' alt='product placeholder'>
        </div>
        <div class=\"box\">
            <span class=\"cart_desc vertical_align_middle \">".$result2['name']."<br>Größe: ".strtoupper($subarray["size"])."</span>
        </div>
        <div class=\"box pricing\">
            <span class=\"cart_price vertical_align_middle \">".$result2['price']." €</span>
        </div>
        <div class=\"box\">
       <input type='hidden' name='qty[".$i."][product_id]' value='".$subarray['product_id']."'>
       <input type='hidden' name='qty[".$i."][size]' value='".$subarray["size"]."'>
               <input class=\"cart-quantity vertical_align_middle \" type=\"number\" name=\"qty[".$i."][quantity]\" min=\"1\" max=\"9\" step=\"1\" value=\"".$subarray["quantity"]."\">
        </div>
        <div class=\"box\">
            <span class=\"cart_price vertical_align_middle \">".$result2['price'] * $subarray["quantity"] ." €</span>
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
                <a style="float: left; margin-top: 30px;" class="btn-link" href="index.php">Weiter einkaufen</a>
                <div class="clearfloat"></div>
            </div>

            </form>

<?php
        } else {
            echo '<div class="error_dialog"> <span class="error_message">Dein Warenkorb ist leer.</span><br>
<a class="btn-link" href="index.php">Zurück zum Shop</a></div>';

        }
    }

    public function getsummary() {

        ?>
<div class="checkout_summary">
        <h2>Zusammenfassung</h2>

        <table style="width:100%">
            <tr>
                <th>Produkt</th>
                <th>Gesamtsumme</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION["cart"] as $subkey => $subarray) {

                $id = $subarray["product_id"];
                $statement = $this->conn->prepare("SELECT * FROM products WHERE id = :id");
                $statement->bindParam(':id', $id);
                $statement->execute();
                $result2 = $statement->fetch();


                if (!empty($result2['img'])) {
                    $imgurl = $result2['img'];}
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
           <span class=\"cart_desc vertical_align_middle \">" . $result2['name'] . "<br>Größe: ".$subarray["size"]."<br>Menge: ".$subarray["quantity"]."</span>
        </div>

    </td>
    <td><span class=\"cart_price vertical_align_middle \">".$result2['price'] * $subarray["quantity"]." €</span></td>
  </tr>
  ";
                //Gesamtsumme berechnen
                $total += $result2['price'] * $subarray["quantity"];

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

<?php
    }

}