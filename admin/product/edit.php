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
                    </div>

                    <div class="col">
                        <p>Klicke auf den untenstehenden Button, um ein neues Produktbild auszuwählen.</p>
                        <label for="file" class="file-label">Produktbild wählen</label>
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

    try {

        move_uploaded_file($_FILES['product_image']['tmp_name'], '../images/products/'.$_FILES['product_image']['name']);

        include_once('../db/connect.php');

        $stmt = $con->prepare("UPDATE products SET `name` = :name, `desc` = :desc, category_id = :category_id, price = :price, artnr = :artnr, img = :img WHERE id = :id ");
        $stmt->bindParam(':name', $product_name);
        $stmt->bindParam(':desc', $product_description);
        $stmt->bindParam(':category_id', $product_category);
        $stmt->bindParam(':price', $product_price);
        $stmt->bindParam(':artnr', $product_artnr);
        $stmt->bindParam(':img', $product_img);
        $stmt->bindParam(':id', $product_id);

        $product_name = $_POST['product_name'];
        $product_description = $_POST['product_desc'];
        $product_category = $_POST['product_category'];
        $product_price = $_POST['product_price'];
        $product_artnr = $_POST['product_artnr'];
        $product_img = $_POST['product_image'];
        $product_id = $_POST['product_id'];

        $stmt->execute();

        echo " Die Änderungen wurden erfolgreich übernommen";
        }
        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
        $con = null;


    }

    ?>
