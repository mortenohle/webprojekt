<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $e_mail = $_POST['e_mail'];
    $passwort = $_POST['passwort'];

    include_once("db/connect.php");

    try {

        $stmt = $con->prepare("SELECT * FROM user WHERE email = :e_mail"); // Datenbankabfrage vorbereiten und in $stmt abspeichern
        $stmt->bindParam(':e_mail', $e_mail);
        $stmt->execute(); // Abfrage ausführen
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // Ergebnis der Abfrage in Array speichern
        $hashAusDatenbank = $row['pw']; // Hash aus der Datenbank versteckt sich in dem Wert ['passwort']

        // Check Nr.1: Ist das Passwort richtig eingegeben
        if (password_verify($passwort, $hashAusDatenbank)) {
            session_start();
            $_SESSION['status'] = true;
            $_SESSION['userid'] = $row["id"];
            $_SESSION['username'] = $row["firstname"];
            header('Location: index.php');
        } else {
            if ($e_mail == $row['e_mail']) {
                echo "Passwort falsch eingegeben";
                session_start();
                $_SESSION['status'] = false;
            } else {
                echo "E-Mail-Adresse nicht in der Datenbank gefunden";
                session_start();
                $_SESSION['status'] = false;
            }

        }

    } catch (PDOException $e) {             // Standard
        echo "Error: " . $e->getMessage();
    }
}
?>

<div class="loginbox">
    <img src="bilder/avatar.png" class="avatar">
    <h1>Login</h1>
    <form action="logincheck.php" method="post">
        <p>E-Mail-Adresse</p>
        <input type="email" size="40" maxlength="150" name="e_mail" placeholder=""<br><br>
        <p>Passwort</p>
        <input type="password" size="40" maxlength="150" name="passwort" placeholder=""<br><br>
        <input type="submit" value="Login"
        <br>
        <a href="passwortvergessen.php">Passwort vergessen?</a><br>
        <a href="registrieren.php">Jetzt Registrieren</a><br>
    </form>
</div>