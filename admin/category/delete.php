<?php
include_once('../db/connect.php');
$cat_id = $_GET["id"];
?>
<h1>Kategorie löschen</h1>

<?php
if ($_GET["action"] == "delete") {
    $stmt = $con->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->bindParam(':id', $cat_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="row-full-width">
        <div class="admin-form">
                <p style="padding-bottom: 26px;">Möchtest du die Kategorie <b><?php echo $row["name"]; ?></b> wirklich löschen?</p>
                <button class="btn-link outline" onclick="window.history.back()">Zurück</button>
                <a class="btn-link" href="index.php?page=category&action=deletesuccess&id=<?php echo $cat_id; ?>" style="margin-left: 10px; padding-top: 11px;">Kategorie löschen</a>
        </div>
    </div>

    <?php
} elseif ($_GET["action"] == "deletesuccess") {

        try {
            include_once('../db/connect.php');

            $stmt = $con->prepare("DELETE FROM categories WHERE id = :id");
            $stmt->bindParam(':id', $cat_id, PDO::PARAM_INT);
            $cat_id = $_GET["id"];
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $con = null;
        echo "<div class='row-full-width'>
        <p>Die Kategorie wurde erfolgreich gelöscht!</p>
        <a class='btn-link' href='index.php?page=category&action=show' style='margin-top: 20px;'>Zu den Kategorien</a>
        </div>
        ";
        }
        ?>
