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

            foreach ($_SESSION["cart"] as $subkey => $subarray) {
                if ($subarray["product_id"] == $id && $subarray["size"] == $size) {
                    $_SESSION["cart"][$subkey]["quantity"] += $quantity;
                } else {
                    $add_to_cart = array("product_id" => $id, "quantity" => $quantity, "size" => $size);
                    // $_SESSION["cart"] = array_merge_recursive( (array)$_SESSION["cart"], (array)$add_to_cart );
                    array_push($_SESSION["cart"], $add_to_cart);
                }

            }

        } else { $_SESSION["cart"] = array(array("product_id" => $id, "quantity" => $quantity, "size" => $size)); }

            echo "<span>Das Produkt wurde zum Warenkorb hinzugefügt. <a href='index.php?page=cart&cart=show'>Zum Warenkorb</a> </span>";

        } else { echo "Die gewählte Größe, Menge des Produkts ist leider nciht mehr auf Lager.";}

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

    public function deleteitem($delete_id) {

        if ($this->cartcount() < 2) { unset($_SESSION["cart"]); } else {
            foreach($_SESSION["cart"] as $subkey => $subarray){
                if($subarray["product_id"] == $delete_id){
                    unset($_SESSION["cart"][$subkey]);
                }
            }}

        echo "Das Produkt wurde erfolgreich entfernt";

    }
    public function getcart() {


        if (isset($_GET["deleteid"])) {
            $this->deleteitem($_GET["deleteid"]);
        }
        if($_POST["update"]) {
            $newcart = $_POST["qty"];
            $this->updateall($newcart);
        }
        if($_POST["coupon"]) {

            echo "Aktuell ist die Gutschein Funktion inaktiv.";

        }

        $totalprice = 0;
        $i = 0;
        if (isset($_SESSION["cart"]) || !empty($_SESSION["cart"])) {
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
            <a href='index.php?page=cart&cart=show&deleteid=".$subarray["product_id"]."' class=\"cart_delete vertical_align_middle\">X</a>
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
               <input class=\"quantity vertical_align_middle \" type=\"number\" name=\"qty[".$i."][quantity]\" min=\"1\" max=\"9\" step=\"1\" value=\"".$subarray["quantity"]."\">
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
            </div>
            <div class="clearfloat"></div>

            </form>

<?php
        } else {
            echo '<div class="error_dialog"> <span class="error_message">Dein Warenkorb ist leer.</span><br>
<a class="btn-link" href="index.php">Zurück zum Shop</a></div>';

        }
    }

}