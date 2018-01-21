<?php
include_once('../db/connect.php');
$cat_id = $_GET["id"];
?>
<h1>Kategorie bearbeiten</h1>

<?php
if ($_GET["action"] == "edit") {
    $stmt = $con->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->bindParam(':id', $cat_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="row-full-width">
        <div class="admin-form">
            <form action="index.php?page=category&action=editsuccess" method="post">
                <h2 class="divider">Allgemeine Informationen</h2>

                <div class="row">
                    <span class="input-heading">Name der Kategorie</span>
                    <input type="text" name="category_name" value="<?php echo $row["name"]; ?>">
                </div>

                <div class="row divider">
                    <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">
                    <input type="submit" value="Änderungen übernehmen">
                </div>

            </form>
        </div>
    </div>

    <?php
} elseif ($_GET["action"] == "editsuccess") {
    $valid = true;
    if (empty($_POST["category_name"])) {
        $Err = "<p class='error_alert'>Der Kategoriename darf nicht leer sein!</p>";
        $valid = false;
    }

    if ($valid) {
        try {
            include_once('../db/connect.php');

            $stmt = $con->prepare("UPDATE categories SET `name` = :category_name WHERE id = :id");
            $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $cat_id, PDO::PARAM_INT);
            $category_name = $_POST['category_name'];
            $cat_id = $_POST['cat_id'];
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $con = null;
        echo "<div class='row-full-width'>
        <h2>Kategorie bearbeitet</h2>
        <p class='new-alert'>Die Kategorie wurde erfolgreich in <b>". $category_name."</b> umbenannt!</p>
        </div>
        <div class='row-full-width'>
        <a class='btn-link' href='index.php?page=category&action=show'>Zu den Kategorien</a>
        </div>";
    } else {
        ?>

        <div class="row-full-width">
            <h2>Es ist ein Fehler aufgetreten!</h2>
            <?php echo $Err; ?>
        </div>
        <div class="row-full-width">
            <button class="btn-link" onclick="window.history.back()">Zurück</button>
        </div>
    <?php } }?>
