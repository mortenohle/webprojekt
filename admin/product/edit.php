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
    <form>
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
    </form>
    </div>
</div>
