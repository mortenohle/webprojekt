<?php

$qualitaet = $_POST['qualitaet'];
$versand = $_POST['versand'];
$passform = $_POST['passform'];
$leistung = $_POST['leistung'];
$kommentar = $_POST['kommentar'];
$produkt_id = $_POST['produkt_id'];
$user_id = $_SESSION['userid'];

include_once("db/connect.php");

$valid = true;
$err = "";
if ($_POST["qualitaet"] == "Bitte wählen") {
    $err .= "Bitte bewerte die Qualität!<br>";
    $valid = false;
}
if ($_POST["versand"] == "Bitte wählen") {
    $err .= "Bitte bewerte Verpackung und Versand!<br>";
    $valid = false;
}
if ($_POST["passform"] == "Bitte wählen") {
    $err .= "Bitte bewerte die Passform!<br>";
    $valid = false;
}
if ($_POST["leistung"] == "Bitte wählen") {
    $err .= "Bitte bewerte Preis-/Leistung!<br>";
    $valid = false;
}

if ($valid) {

    try {
        $insert = $con->prepare("INSERT INTO rating (id, produkt_id, user_id, qualitaet, versand, passform, leistung, kommentar, `date`) VALUES ( :id, :produkt_id, :user_id, :qualitaet, :versand, :passform, :leistung, :kommentar, CURDATE())");
        $myNull = null;
        $insert->bindParam(":id", $myNull, PDO::PARAM_INT);
        $insert->bindParam(":produkt_id", $produkt_id, PDO::PARAM_INT);
        $insert->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $insert->bindParam(":qualitaet", $qualitaet, PDO::PARAM_STR);
        $insert->bindParam(":versand", $versand, PDO::PARAM_STR);
        $insert->bindParam(":passform", $passform, PDO::PARAM_STR);
        $insert->bindParam(":leistung", $leistung, PDO::PARAM_STR);
        $insert->bindParam(":kommentar", $kommentar, PDO::PARAM_STR);
        $insert->execute();
        if ($insert !== false) ;

        echo "
        <div class='loginbox'>
            <h1>Produkt bewertet!</h1>
            <p>Deine Bewertung wurde erfolgreich gespeichert!</p>
            <a class='btn-link fw' href='index.php?page=product&product=show&id=".$produkt_id."'>Zurück zum Produkt!</a>
        </div>
        ";


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "
        <div class='loginbox'>
            <h1>Bitte alle Felder ausfüllen!</h1>
            <p>".$err."</p>
            <button class='btn-link outline fw' onclick='window.history.back()'>Zurück</button>
        </div>
    ";
}

?>