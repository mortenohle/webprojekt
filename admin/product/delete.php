<?php
include_once('../db/connect.php');
$product_id = $_GET["id"];
?>
<h1>Produkt löschen</h1>

<?php
if ($_GET["action"] == "delete") {
    $stmt = $con->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="row-full-width">
        <div class="admin-form">
            <p style="padding-bottom: 26px;">Möchtest du das Produkt <b><?php echo $row["name"]; ?></b> wirklich löschen?</p>
            <button class="btn-link outline" onclick="window.history.back()">Zurück</button>
            <a class="btn-link" href="index.php?page=product&action=deletesuccess&id=<?php echo $product_id; ?>" style="margin-left: 10px; padding-top: 11px;">Produkt löschen</a>
        </div>
    </div>

    <?php
} elseif ($_GET["action"] == "deletesuccess") {

    try {
        include_once('../db/connect.php');

        $stmt = $con->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
        $product_id = $_GET["id"];
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $con = null;
    echo "<div class='row-full-width'>
        <p>Das Produkt wurde erfolgreich gelöscht!</p>
        <a class='btn-link' href='index.php?page=product&action=show' style='margin-top: 20px;'>Zu den Produkten</a>
        </div>
        ";
}
?>