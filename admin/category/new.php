<h1>Kategorie hinzufügen</h1>

<?php
if ($_GET["action"] == "new") {
    ?>
    <div class="row-full-width">
        <div class="admin-form">
            <form action="index.php?page=category&action=newsuccess" method="post">
                <h2 class="divider">Allgemeine Informationen</h2>

                <div class="row">
                    <span class="input-heading">Name der Kategorie</span>
                    <input type="text" name="category_name">
                    <?php echo $Err; ?>
                </div>

                <div class="row divider">
                    <input type="submit" value="Kategorie hinzufügen">
                </div>

            </form>
        </div>
    </div>

    <?php
} elseif ($_GET["action"] == "newsuccess") {
    $valid = true;
    if (empty($_POST["category_name"])) {
        $Err = "<p class='error_alert'>Bitte einen Kategorienamen eingeben!</p>";
        $valid = false;
    }

    if ($valid) {
        try {
            include_once('../db/connect.php');

            $stmt = $con->prepare("INSERT INTO categories (id, `name`) VALUES (:id, :category_name)");
            $myNull = null;
            $stmt->bindParam(':id', $myNull, PDO::PARAM_NULL);
            $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
            $category_name = $_POST['category_name'];
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $con = null;
        echo "<div class='row-full-width'>
        <h2>Kategorie hinzugefügt</h2>
        <p class='new-alert'>Die Kategorie <b>". $category_name."</b> wurde erfolgreich hinzugefügt!</p>
        </div>
        <div class='row-full-width'>
        <button class='btn-link' href='index.php?page=category&action=show'>Zu den Kategorien</button>
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
