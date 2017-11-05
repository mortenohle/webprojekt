<h1>Produkt bearbeiten</h1>

<?php
$id = $_GET['id'];
include_once('../db/connect.php');

$sql = "SELECT * FROM products WHERE id = ".$id;
$result =$con->query($sql);
$row = $result->fetch();

?>

<div class="row-full-width">
    <div class="admin-form">
    <form action="" method="post" enctype="multipart/form-data">
        <h2 class="divider">Allgemeine Informationen</h2>

        <div class="row">
            <span class="input-heading">Produktname</span>
            <input type="text" value="<?php echo $row["name"]; ?>">
        </div>

        <div class="row">
            <span class="input-heading">Kategorie</span>
            <select>
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

                        echo "<option ".$selected.">".$row_cat['name']."</option>";
                    }
                ?>
            </select>
        </div>

        <div class="row-2-col">
            <div class="col">
                <span class="input-heading">Preis in €</span>
                <input type="text" value="<?php echo $row["price"]; ?>">
            </div>
            <div class="col">
                <span class="input-heading">Artikelnummer</span>
                <input type="text" value="<?php echo $row["artnr"]; ?>">
            </div>
        </div>

        <div class="row">
            <span class="input-heading">Produktbeschreibung</span>
            <textarea><?php echo $row["desc"]; ?></textarea>
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
                <input type="file" id="file" onchange="readURL(this);" />
            </div>
        </div>

        <div class="row divider">
            <input type="submit" value="Änderungen übernehmen">
        </div>

    </form>
    </div>
</div>
