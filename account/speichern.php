<?php
$vorname = $_POST['vorname'];
$nachname = $_POST['nachname'];
$e_mail = $_POST['e_mail'];
$e_mail_wiederholen = $_POST['e_mail_wiederholen'];
$passwort = $_POST['passwort'];
$passwort_wiederholen = $_POST['passwort_wiederholen'];
$hash = password_hash($passwort, PASSWORD_DEFAULT);

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
if (empty($_POST["e_mail"])) {
    $err .= "Bitte gib deine E-Mail-Adresse an!<br>";
    $valid = false;
}
if (empty($_POST["e_mail_wiederholen"])) {
    $err .= "Bitte wiederhole deine E-Mail-Adresse!<br>";
    $valid = false;
}
if (empty($_POST["passwort"])) {
    $err .= "Bitte gib ein Passwort ein!<br>";
    $valid = false;
}
if (empty($_POST["passwort_wiederholen"])) {
    $err .= "Bitte wiederhole dein Passwort ein!<br>";
    $valid = false;
}


if ($valid) {

    try {

        $stmt = $con->prepare("SELECT COUNT(*) c FROM user WHERE email = :e_mail"); // Datenbankabfrage vorbereiten und in $stmt abspeichern
        $stmt->bindParam(':e_mail', $e_mail); // Variable wird auf stmt noch hinzugefügt: Variable=E-Mail-Adresse
        $stmt->execute(); // Abfrage ausführen
        $count = $stmt->fetch(PDO::FETCH_ASSOC); // Ergebnis der Abfrage in Array speichern

    } catch (PDOException $e) {             // Standard
        echo "Error: " . $e->getMessage();
    }

    if ($count["c"] == 0) {
        if ($passwort == $passwort_wiederholen) {
            if ($e_mail == $e_mail_wiederholen) {
                try {
                    $insert = $con->prepare("INSERT INTO user(id, lastname, firstname, email, pw) VALUES (:id, :nachname, :vorname, :e_mail, :passwort)");
                    $myNull = null;
                    $insert->bindParam(":id", $myNull, PDO::PARAM_NULL);
                    $insert->bindParam(":vorname", $vorname, PDO::PARAM_STR);
                    $insert->bindParam(":nachname", $nachname, PDO::PARAM_STR);
                    $insert->bindParam(":e_mail", $e_mail, PDO::PARAM_STR);
                    $insert->bindParam(":passwort", $hash, PDO::PARAM_STR);
                    $insert->execute();
                    if ($insert !== false) ;
                    $success = "Dein Account wurde erfolgreich angelegt!<br>";

                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }

                $con = null;
            } else {
                $err .= "Deine E-Mail-Adressen stimmen nicht überein!<br>";
            }
        } else {
            $err .= "Deine Passwörter stimmen nicht überein<br>";
        }
    } else {
        $err .= "Diese E-Mail-Adresse wird leider schon verwendet<br>";
    }
}
?>

<div class="registrierungsbox">
    <h1>Registrierung</h1>
    <?php
        if ($err !== "") {
            echo $err . "<br><button class='btn-link outline' onclick='window.history.back()'>Zurück</button>";
        }
        echo $success . "<br><a href='index.php' class='btn-link'>Zur Startseite</a>";

    ?>


</div>