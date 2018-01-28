<?php
include_once("db/connect.php");

$stmt = $con->prepare ("SELECT * from user WHERE id='" . $_SESSION["userid"] . "'");
$row = $stmt->fetch(PDO::FETCH_ASSOC); // Ergebnis der Abfrage in Array speichern

if($_POST["currentPassword"] == $row["pw"]) {
    $req = ("UPDATE user set pw='" . $_POST["newPassword"] . "' WHERE id='" . $_SESSION["userid"] . "'");
    $stmt = $con->prepare ($req);
    $stmt->execute();

$message = "Password Changed";
} else $message = "Current Password is not correct";

?>