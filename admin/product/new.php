<?php
    include_once('../db/connect.php');
?>
<h1>Produkt hinzufügen</h1>

<?php
if ($_GET["action"] == "new") {
    ?>

    <div class="row-full-width">
        <div class="admin-form">
            <form action="index.php?page=product&action=newsuccess" method="post" enctype="multipart/form-data">
            <h2 class="divider">Allgemeine Informationen</h2>

            <div class="row">
                <span class="input-heading">Produktname</span>
                <input type="text" name="product_name">
            </div>

            <div class="row">
                <span class="input-heading">Kategorie</span>
                <select name="product_category">
                    <?php
                    echo "<option value='choose_cat' selected>Kategorie wählen</option>";
                    $sql_cat = "SELECT * FROM categories";

                    foreach ($con->query($sql_cat) as $row_cat) {
                        echo "<option value='" . $row_cat['id'] . "'>" . $row_cat['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="row-2-col">
                <div class="col">
                    <span class="input-heading">Preis (ohne €-Zeichen eingeben)</span>
                    <input type="text" placeholder="z.B. 79.99" name="product_price">
                </div>
                <div class="col">
                    <span class="input-heading">Artikelnummer</span>
                    <input type="text" name="product_artnr">
                </div>
            </div>

                <div class="row">
                    <span class="input-heading">EAN-Code</span>
                    <input type="text" name="product_ean">
                </div>

            <div class="row">
                <span class="input-heading">Produktbeschreibung</span>
                <textarea name="product_desc"></textarea>
            </div>

                <h2 class="divider">Lagerbestand</h2>

                <div class="row-2-col">
                    <div class="col">
                        <span class="input-heading">Größe S</span>
                        <input type="number" placeholder="Anzahl" name="size_s">
                    </div>
                    <div class="col">
                        <span class="input-heading">Größe M</span>
                        <input type="number" name="size_m" placeholder="Anzahl">
                    </div>
                </div>

                <div class="row-2-col">
                    <div class="col">
                        <span class="input-heading">Größe L</span>
                        <input type="number" placeholder="Anzahl" name="size_l">
                    </div>
                    <div class="col">
                        <span class="input-heading">Größe XL</span>
                        <input type="number" name="size_xl" placeholder="Anzahl">
                    </div>
                </div>

            <script type="text/javascript">
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#productimage').attr('src', e.target.result);
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>

            <h2 class="divider" style="padding-top: 20px;">Produktbild</h2>

            <div class="row-2-col">
                <div class="col">
                    <img src="../images/products/placeholder.jpg" alt="Produktbild" id="productimage">
                    <input type="hidden" name="current_img" value="<?php echo $imgurl; ?>">
                </div>

                <div class="col">
                    <p>Klicke auf den untenstehenden Button, um ein Produktbild auszuwählen.</p>
                    <label for="file" class="file-label">Produktbild wählen</label>
                    <input type="file" id="file" name="product_image" onchange="readURL(this);"/>
                </div>
            </div>

            <div class="row divider">
                <input type="submit" value="Produkt hinzufügen">
            </div>
            </form>

        </div>
    </div>
    <?php
        } elseif ($_GET["action"] == "newsuccess") {

    $valid = true;
    if (empty($_POST["product_name"])) {
        $err_name = "Bitte gib einen Produktnamen an!<br>";
        $valid = false;
    }
    if ($_POST["product_category"] == "choose_cat") {
        $err_cat = "Bitte wähle eine Kategorie!<br>";
        $valid = false;
    }
    if (empty($_POST["product_price"])) {
        $err_price = "Bitte gib einen Preis für das Produkt an!<br>";
        $valid = false;
    }
    if (empty($_POST["product_artnr"])) {
        $err_artnr = "Bitte gib eine Artikelnummer an!<br>";
        $valid = false;
    }
    if (empty($_POST["product_ean"])) {
        $err_artnr = "Bitte gib den EAN-Code ein!<br>";
        $valid = false;
    }

    if ($valid) {
        try {

            //IMG Upload Ordner, Dateiname & Dateityp
            $product_img_folder = '../images/products/';
            $product_img_name = pathinfo($_FILES['product_image']['name'], PATHINFO_FILENAME);
            $product_img_filetype = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));

            if (!empty($_POST["product_image"])) {
                //Überprüfung des IMG-Dateityps
                $allowed_filetype = array('jpg', 'jpeg', 'png', 'gif');
                if (!in_array($product_img_filetype, $allowed_filetype)) {
                    die("Ungültiger Dateityp. Bitte lade nur nur jpg, jpeg, png oder gif-Dateien hoch");
                }
            }

            $upload_path = $product_img_folder . $product_img_name . '.' . $product_img_filetype;

            if (file_exists($upload_path)) {
                $id = 1;
                do {
                    $upload_path = $product_img_folder . $product_img_name . '_' . $id . '.' . $product_img_filetype;
                    $id++;
                } while (file_exists($upload_path));
            }

            move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_path);

            include_once('../db/connect.php');

            $product_name = $_POST['product_name'];
            $product_desc = $_POST['product_desc'];
            $product_category = $_POST['product_category'];
            $product_price = $_POST['product_price'];
            $product_artnr = $_POST['product_artnr'];
            $product_ean = $_POST['product_ean'];
            $product_img = $_FILES['product_image']['name'];
            $size_s = $_POST['size_s'];
            $size_m = $_POST['size_m'];
            $size_l = $_POST['size_l'];
            $size_xl = $_POST['size_xl'];

            $placeholder_img = "placeholder.jpg";

            if ($product_img == "") {
                $product_img_url = $placeholder_img;
            } else {
                $product_img_url = $product_img;
            }

            $stmt = $con->prepare("INSERT INTO products (id, `name`, `desc`, category_id, price, artnr, img, ean) VALUES (:id, :product_name, :product_desc, :category_id, :price, :artnr, :img, :ean)");
            $myNull = null;
            $stmt->bindParam(':id', $myNull, PDO::PARAM_NULL);
            $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
            $stmt->bindParam(':product_desc', $product_desc, PDO::PARAM_STR);
            $stmt->bindParam(':category_id', $product_category, PDO::PARAM_INT);
            $stmt->bindParam(':price', $product_price, PDO::PARAM_STR);
            $stmt->bindParam(':artnr', $product_artnr, PDO::PARAM_INT);
            $stmt->bindParam(':img', $product_img_url, PDO::PARAM_STR);
            $stmt->bindParam(':ean', $product_ean, PDO::PARAM_INT);

            $stmt->execute();

            $last_id = $con->lastInsertId();

            $stmt_order = $con->prepare("INSERT INTO stock (id, product_id, s, m, l, xl) VALUES (:stock_id, :product_id, :s, :m, :l, :xl)");
            $myNull = null;
            $stmt_order->bindParam(':stock_id', $myNull, PDO::PARAM_NULL);
            $stmt_order->bindParam(':product_id', $last_id, PDO::PARAM_STR);
            $stmt_order->bindParam(':s', $size_s, PDO::PARAM_INT);
            $stmt_order->bindParam(':m', $size_m, PDO::PARAM_INT);
            $stmt_order->bindParam(':l', $size_l, PDO::PARAM_INT);
            $stmt_order->bindParam(':xl', $size_xl, PDO::PARAM_INT);
            $stmt_order->execute();


            echo "
            <div class='row-full-width'>
            Das Produkt wurde erfolgreich hinzugefügt!
            </div>
            <div class='row-full-width'>
                <a href='index.php?page=product&action=show' class='btn-link'>Zu den Produkten</a>
            </div>
            ";

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $con = null;

    } else {
        echo "
            <div class='row-full-width'>
            <h2 class='divider'>Es ist ein Fehler aufgetreten</h2>
            ".$err_name. $err_cat. $err_price. $err_artnr."
            </div>
            <div class='row-full-width'>
                <button class='btn-link' onclick='window.history.back()'>Zurück</button>
            </div>
            ";
    }
}// Ende newsuccess
    ?>