<script>
    $(document).ready(function () {
        $('.user-profile').addClass('active');
    })
</script>
<div id="wrapper_kundendaten">

    <h1>Mein Profil</h1>

    <?php

    $id = $_SESSION["userid"];
    include_once("db/connect.php");
    if(isset($_SESSION["username"])) {

        include ("account/sidenav-profile.php");
        ?>

        <div class="content_kundenkonto">
            <h2>Hallo <?php echo $_SESSION["username"]; ?></h2>

            <div class="container_kundenkonto">
                <div class="kundenkonto_col meine_daten">

                    <?php
                    $sql = $con->prepare("SELECT * FROM user WHERE id = :id");
                    $sql->bindParam(':id', $id);
                    $sql->execute();
                    $row = $sql->fetch(PDO::FETCH_ASSOC);
                    ?>

                    <h3>Persönliche Daten</h3>
                    <p>
                        <span class="select_heading">Vorname</span>
                        <?php echo $row["firstname"]; ?>
                    </p>
                    <p>
                        <span class="select_heading">Nachname</span>
                        <?php echo $row["lastname"]; ?>
                    </p>
                    <p>
                        <span class="select_heading">E-Mail-Adresse</span>
                        <?php echo $row["email"]; ?>
                    </p>

                    <h3>Rechungs-/Lieferadrese</h3>
                    <p>
                        <span class="select_heading">Straße, Nr.</span>
                        <?php echo $row["address"]; ?>
                    </p>
                    <p>
                        <span class="select_heading">PLZ</span>
                        <?php echo $row["postcode"]; ?>
                    </p>
                    <p>
                        <span class="select_heading">Ort</span>
                        <?php echo $row["city"]; ?>
                    </p>
                    <a href="index.php?page=account&action=profileedit" class="btn-link">Meine Daten ändern!</a>

                </div>
                <div class="kundenkonto_col meine_bestellungen">
                    <h3>Deine letzten Bestellungen</h3>

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
                                echo "<div class='complete-order'>
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
                            <div class='single-order'>
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
                        <div class='order-summary'>
                            Summe: <span class='price-output'>" . $price_total . "</span> €
                        </div>
                        </div>";
                            }

                        }
                    } else {
                        echo "<p>Bisher hast du noch nichts bei uns im Shop bestellt!</p>";
                    }

                    ?>

                    <a href="index.php?page=account&action=myorders" class="btn-link">Alle Bestellungen ansehen!</a>

                </div>
            </div>
        </div>




    <?php } else { ?>

        <p style="padding-bottom: 20px;">Du musst angemeldet sein, um diese Seite sehen zu können!</p>
        <a class="btn-link" href="index.php?page=account&action=login">Zur Anmeldung!</a>

    <?php } ?>
</div>