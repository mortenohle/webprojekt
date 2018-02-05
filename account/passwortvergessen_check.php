<?php

function random_string() {
    if(function_exists('random_bytes')) {
        $bytes = random_bytes(16);
        $str = bin2hex($bytes);
    } else if(function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(16);
        $str = bin2hex($bytes);
    } else if(function_exists('mcrypt_create_iv')) {
        $bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
        $str = bin2hex($bytes);
    } else {
        $str = md5(uniqid('e_mail_string', true));
    }
    return $str;
}

$e_mail=$_POST['e_mail'];

include_once("db/connect.php");

try {

    $stmt = $con->prepare("SELECT * FROM user WHERE email = :e_mail"); // Datenbankabfrage vorbereiten und in $stmt abspeichern
    $stmt->bindParam(':e_mail', $e_mail);
    $stmt->execute(); // Abfrage ausführen
    $row = $stmt->fetch(PDO::FETCH_ASSOC); // Ergebnis der Abfrage in Array speichern
}

catch(PDOException $e) {             // Standard
    echo "Error: ". $e->getMessage();
}

// Check Nr.1: Ist E-Mail-Adresse in der Datenbank hinterlegt?

//echo $row['e_mail'];
//echo $row['id'];

if(count($row)==0) {
    echo "E-Mail Adresse ist nicht in der Datenbank hinterlegt";
} else {
    $passwortcode=random_string();
    $stmt = $con->prepare("UPDATE user SET passwortcode=:passwortcode, passwortcode_time=NOW() WHERE id=:user_id");
    $result= $stmt->execute(array('passwortcode'=> sha1($passwortcode),'user_id'=>$row['id']));

    //E-Mail für Empfänger, der das Passwort vergessen hat wird vorbereitet
    $empfaenger=$row['email'];
    $betreff="Dein neues Passwort für deinen Account";
    $absender="From:LOGO Shop <info@logoshop.de>";
    $url_passwortcode="https://mars.iuk.hdm-stuttgart.de/~mo043/index.php?page=account&action=pwneu&userid=".$row['id']."&code=".$passwortcode;
    $text="Hallo ".$row['firstname'].",\n\nfür deinen Account auf LOGO wurde nach einem neuem Passwort gefragt. Um ein neues Passwort zu vergeben, rufe innerhalb der nächsten 24h die folgende Website auf:\n\n"
    .$url_passwortcode;

    mail($empfaenger,$betreff,$text,$absender);
    echo "
    <div class='loginbox'>
    <h1>Passwort vergessen</h1>
    <p>Ein Link wurde eben an deine E-Mail-Adresse versendet</p>
    <a href='index.php' class='btn-link pw-form'>Zur Startseite</a>
    </div>";


}







