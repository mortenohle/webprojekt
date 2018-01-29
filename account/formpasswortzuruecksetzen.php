<?php
include_once("db/connect.php");

// Überprüfung, ob user_id und passwortcode übergeben wurde
$user_id=$_GET['userid'];
$passwortcode=$_GET['code'];

//Überprüfung, ob Link zum Passwort zurücksetzten einen Inhalt in user_id und in passwortcode haben - die() beendet die Skriptausführung

if($user_id === NULL || $passwortcode=== NULL){
    echo "Nutzer hat kein Passwortcode angefordert";
    die();
}

// Nur Abfrage des Nutzers?
try {

    $stmt = $con->prepare("SELECT * FROM user WHERE id = :user_id"); // Datenbankabfrage vorbereiten und in $stmt abspeichern
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute(); // Abfrage ausführen
    $row = $stmt->fetch(PDO::FETCH_ASSOC); // Ergebnis der Abfrage in Array speichern
}

catch(PDOException $e) {             // Standard
    echo "Error: ". $e->getMessage();
}


if(sha1($passwortcode)===$row['passwortcode']){
    // Überprüfung, ob Passwortcode die Gültigkeit von 24h überschreitet
    $passwortcode_time = strtotime($row['passwortcode_time']);
    if($passwortcode_time < (time()-24*3600)){
        echo "Passwortcode wurde vor mehr als 24h angefordert, bitte erneut versuchen";
        die();
    } else {
        echo "
            <div class='loginbox'>
                <h1>Neues Passwort</h1>
                <form method='post' action='index.php?page=account&action=pwneusuccess' class='pwvergessen'>
                    <input type='hidden' value='". $row['id'] ."' name='id'>
                    <span class='input-heading'>Neues Passwort eingeben:</span>
                    <input type='password' name='password'>
                    <span class='input-heading'>Passwort wiederholen:</span>
                    <input type='password' name='password_2'>
                    <input type='submit' value='Zurücksetzen'>
                 </form>
            </div>   
        ";
    }

}
