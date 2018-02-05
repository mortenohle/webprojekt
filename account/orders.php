<?php
if(isset($_SESSION["username"])) {
    $id = $_SESSION["userid"];

    include_once("db/connect.php");

    $sql = $con->prepare("SELECT * FROM user WHERE id = :id");
    $sql->bindParam(':id', $id); // Variable wird auf stmt noch hinzugefügt: Variable=E-Mail-Adresse
    $sql->execute(); // Abfrage ausführen
    $row = $sql->fetch(PDO::FETCH_ASSOC);

    ?>
    <script>
        $(document).ready(function () {
            $('.user-orders').addClass('active');
        })
    </script>
    <div id="wrapper_kundendaten">

        <h1>Mein Profil</h1>

        <?php
        include ("account/sidenav-profile.php");
        ?>


        <div class="content_kundenkonto">

            <h2>Meine Bestellungen</h2>

            <?php

            $sql_count = $con->prepare("SELECT COUNT(*) c FROM orders WHERE user_id = :user_id");
            $sql_count->bindParam(':user_id', $id);
            $sql_count->execute();
            $count = $sql_count->fetch(PDO::FETCH_ASSOC);

            $sql_orders = $con->prepare("SELECT * FROM orders WHERE user_id = :user_id");
            $sql_orders->bindParam(':user_id', $id);
            $sql_orders->execute();

            if ($count["c"] != 0) {
                while ($orders = $sql_orders->fetch()) {


                    $array = $orders['products'];
                    $product = json_decode($array, true);

                    if (is_array($product) || is_object($product)) {
                        echo "<div class='complete-order fw'>
                        <div class='order-number'>Bestellnr. " . $orders['id'] . "</div>
                        ";

                        $price_total = 0;
                        foreach ($product as $row) {

                            $sql_product = $con->prepare("SELECT * FROM products WHERE id = :product_id");
                            $sql_product->bindParam(':product_id', $row['product_id']);
                            $sql_product->execute();
                            $product = $sql_product->fetch(PDO::FETCH_ASSOC);

                            $price = $row['quantity'] * $row['price'];
                            $price_total += $price;

                            echo "
                            <div class='single-order fw'>
                                <div class='order-img'>
                                    <div class='img-thumb' style='background-image: url(images/products/" . $product['img'] . ");'>
                                    </div>
                                </div>
                                <div class='order-detail'>
                                    <span class='name'><b>" . $product['name'] . "</b></span>
                                    <span class='size'>Größe: <span class='size-output'>" . $row['size'] . "</span></span>
                                    <span class='count'>Anzahl: " . $row['quantity'] . "</span>
                                    <span class='price'>Preis: " . $price . " €</span>
                                </div>
                            </div>
                            
                            ";
                        }
                        echo "
                        <div class='order-fw-footer'>
                            <div class='order-col'>
                                <span class='order-adresse'>Liefer-/Rechnungsadresse</span>" . $orders['address'] . "
                            </div>
                            <div class='order-col total'>SUMME: <b>".$price_total." €</b></div>
                        </div>
                        </div>";
                    }

                }
            } else {
                echo "<p>Bisher hast du noch nichts bei uns im Shop bestellt!</p>";
            }

            ?>

        </div>

    </div>
<?php } else { ?>
    <p style="padding-bottom: 20px;">Du musst angemeldet sein, um diese Seite sehen zu können!</p>
    <a class="btn-link" href="index.php?page=account&action=login">Zur Anmeldung!</a>
<?php } ?>