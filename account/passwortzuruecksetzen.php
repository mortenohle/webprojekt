<?php
include_once("db/connect.php");

$passwort = $_POST['password'];
$passwort_wiederholen = $_POST['password_2'];
$hash = password_hash($passwort, PASSWORD_DEFAULT);
$user_id = $_POST['id'];

if ($passwort === NULL || $passwort == $passwort_wiederholen) {
    $stmt = $con->prepare("UPDATE user SET pw=:passwort WHERE id=:user_id");
    $result= $stmt->execute(array('passwort'=> $hash,'user_id'=>$user_id));
    echo"
        <div class='loginbox'>
            <h1>Passwort zurückgesetzt!</h1>
            <p>Dein Passwort wurde erfolgreich zurückgesetzt!</p>
            <a href='index.php?page=account&action=login' class='btn-link pw-form'>Zurück zu Anmeldung</a>
        </div>
 ";
} else {
    echo "
        <div class='loginbox'>
            <h1>Passwort zurückgesetzt!</h1>
            <p>Es ist ein Fehler aufgetreten, versuche es bitte erneut!</p>
            <button class='btn-link outline pw-form' onclick='window.history.back()'>Zurück</button>
        </div>
    ";

}