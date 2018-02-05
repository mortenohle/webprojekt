<?php
$vorname = $_POST['vorname'];
$nachname = $_POST['nachname'];
$passwort = $_POST['passwort'];
$passwort_wiederholen = $_POST['passwort_wiederholen'];
$hash = password_hash($passwort, PASSWORD_DEFAULT);
$adresse = $_POST['adresse'];
$plz = $_POST['plz'];
$ort = $_POST['ort'];
$id = $_POST['id'];


include_once("db/connect.php");

$valid = true;
$err = "";
if (empty($_POST["vorname"])) {
    $err .= "Bitte gib deinen Vornamen an!<br>";
    $valid = false;
}
if (empty($_POST["nachname"])) {
    $err .= "Bitte gib deinen Nachnamen an!<br>";
    $valid = false;
}
if (empty($_POST["adresse"])) {
    $err .= "Bitte gib deine Adresse ein!<br>";
    $valid = false;
}
if (empty($_POST["plz"])) {
    $err .= "Bitte gib deine PLZ ein!<br>";
    $valid = false;
}
if (empty($_POST["ort"])) {
    $err .= "Bitte gib dein Ort ein!<br>";
    $valid = false;
}
if ($passwort != "") {
    if ($passwort != $passwort_wiederholen) {
        $err .= "Deine Passwörter stimmen nicht überein!";
        $valid = false;
    }
}

if ($valid) {

    try {

            if ($passwort == "") {
                $stmt = $con->prepare("UPDATE user SET lastname = :lastname, firstname = :firstname, address = :address, postcode = :postcode, city = :city WHERE id = :user_id");
            } else {
                $stmt = $con->prepare("UPDATE user SET lastname = :lastname, firstname = :firstname, pw = :pw, address = :address, postcode = :postcode, city = :city WHERE id = :user_id");
            }

            $stmt->bindParam(":firstname", $vorname, PDO::PARAM_STR);
            $stmt->bindParam(":lastname", $nachname, PDO::PARAM_STR);
            if ($passwort != "") {
                $stmt->bindParam(":pw", $hash, PDO::PARAM_STR);
            }
            $stmt->bindParam(":address", $adresse, PDO::PARAM_STR);
            $stmt->bindParam(":postcode", $plz, PDO::PARAM_INT);
            $stmt->bindParam(":city", $ort, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $id, PDO::PARAM_STR);
            $stmt->execute();
            $success = true;


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

}
?>

<script>
    $(document).ready(function () {
        $('.user-edit').addClass('active');
    })
</script>
<div id="wrapper_kundendaten">

    <h1>Mein Profil</h1>

        <?php
        include ("account/sidenav-profile.php");
        ?>


    <div class="content_kundenkonto alert">
        <?php
        if ($success) {
            echo "<p>Deine Daten wurden erfolgreich gespeichert</p><br><a href='index.php?page=account&action=myprofile' class='btn-link'>Zur Übersicht</a>";
        }
        if ($err != "") {
            echo $err . "<br><button class='btn-link outline' onclick='window.history.back()'>Zurück</button>";
        }
        ?>
    </div>
</div>
