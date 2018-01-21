<h1>Produkt bearbeiten</h1>

<?php
$id = $_GET['id'];

if ($_GET["action"] == "edit") {

    include_once('../db/connect.php');

    $sql = "SELECT * FROM products WHERE id = ".$id;
    $result =$con->query($sql);
    $row = $result->fetch();
    ?>

    <div class="row-full-width">
        <div class="admin-form">
            <form action="index.php?page=product&action=editsuccess" method="post" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                <h2 class="divider">Allgemeine Informationen</h2>

                <div class="row">
                    <span class="input-heading">Produktname</span>
                    <input type="text" value="<?php echo $row["name"]; ?>" name="product_name">
                </div>

                <div class="row">
                    <span class="input-heading">Kategorie</span>
                    <select name="product_category">
                        <?php
                        $sql_cat = "SELECT * FROM categories";

                        foreach ($con->query($sql_cat) as $row_cat) {

                            $catid1 = $row["category_id"];
                            $catid2 = $row_cat["id"];

                            if ($catid1 == $catid2) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }

                            echo "<option " . $selected . " value='" . $row_cat['id'] . "'>" . $row_cat['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="row-2-col">
                    <div class="col">
                        <span class="input-heading">Preis in €</span>
                        <input type="text" value="<?php echo $row["price"]; ?>" name="product_price">
                    </div>
                    <div class="col">
                        <span class="input-heading">Artikelnummer</span>
                        <input type="text" value="<?php echo $row["artnr"]; ?>" name="product_artnr">
                    </div>
                </div>

                <div class="row">
                    <span class="input-heading">Produktbeschreibung</span>
                    <textarea name="product_desc"><?php echo $row["desc"]; ?></textarea>
                </div>

                <?php
                // Abfrage Produktbild
                if ($row['img'] == "") {
                    $imgurl = "placeholder.jpg";
                } else {
                    $imgurl = $row['img'];
                }
                ?>

                <script type="text/javascript">
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function (e) {
                                $('#productimage').attr('src', e.target.result);
                            }

                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>

                <h2 class="divider" style="padding-top: 20px;">Produktbild</h2>

                <div class="row-2-col">
                    <div class="col">
                        <img src="../images/products/<?php echo $imgurl; ?>" alt="Produktbild" id="productimage">
                        <input type="hidden" name="current_img" value="<?php echo $imgurl; ?>">
                    </div>

                    <div class="col">
                        <p>Klicke auf den untenstehenden Button, um ein neues Produktbild auszuwählen.</p>
                        <label for="file" class="file-label">Neues Produktbild wählen</label>
                        <input type="file" id="file" name="product_image" onchange="readURL(this);"/>
                    </div>
                </div>

                <div class="row divider">
                    <input type="submit" value="Änderungen übernehmen">
                </div>

            </form>
        </div>
    </div>

    <?php
    } elseif ($_GET["action"] == "editsuccess") {

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
                    die("Ungültiger Dateityp. Bitte lade nur nur jpg, jpeg, png und gif-Dateien hoch");
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

            $stmt = $con->prepare("UPDATE products SET `name` = :name, `desc` = :desc, category_id = :category_id, price = :price, artnr = :artnr, img = :img WHERE id = :id ");
            $stmt->bindParam(':name', $product_name);
            $stmt->bindParam(':desc', $product_description);
            $stmt->bindParam(':category_id', $product_category);
            $stmt->bindParam(':price', $product_price);
            $stmt->bindParam(':artnr', $product_artnr);
            $stmt->bindParam(':img', $product_img_url);
            $stmt->bindParam(':id', $product_id);

            $product_name = $_POST['product_name'];
            $product_description = $_POST['product_desc'];
            $product_category = $_POST['product_category'];
            $product_price = $_POST['product_price'];
            $product_artnr = $_POST['product_artnr'];
            $product_id = $_POST['product_id'];
            $product_img = $_FILES['product_image']['name'];

            $current_img = $_POST['current_img'];

            if ($product_img == "") {
                $product_img_url = $current_img;
            } else {
                $product_img_url = $product_img;
            }

            $stmt->execute();

            echo "
            <div class='row-full-width'>
            Die Änderungen wurden erfolgreich übernommen!
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

    } // Ende editsuccess

    ?>
