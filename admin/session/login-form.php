<?php

$userErr = $passwortErr = "";
$user = $passwort = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;

    if (empty($_POST["username"])) {
        $userErr = "Benutzernamen eingeben!";
        $valid = false;
    } else {
        $user = strtolower($_POST["username"]);
    }

    if (empty($_POST["password"])) {
        $passwortErr = "Passwort eingeben!";
        $valid = false;
    } else {
        $password = $_POST["password"];
    }

}

if($valid) {
    include_once('../db/connect.php');

    $loginErr = "";

    try {
        $stmt = $con->prepare("SELECT * FROM adminuser WHERE user_name = :user_name");
        $stmt->bindParam(':user_name', $user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: ". $e->getMessage();
    }

    if ($stmt !== false && password_verify($password, $result["password"])) {
        $_SESSION["admin_userid"] = $result["id"];
        $_SESSION["admin_firstname"] = $result["first_name"];
        header('Location: index.php');
    } else {
        $loginErr = "Benutzername oder Passwort ungültig!";
    }

}

?>

<?php
if($userErr != "") {
    echo "<div class='form-alert'>". $userErr . "</div>";
}
if($passwortErr != "") {
    echo "<div class='form-alert'>". $passwortErr . "</div>";
}
if($loginErr != "") {
    echo "<div class='form-alert'>". $loginErr . "</div>";
}
?>
<form method="post" action="">
    <div class="row">
        <span class="input-heading">Benutzername</span>
        <input type="text" name="username" placeholder="Benutzername">
    </div>
    <div class="row">
        <span class="input-heading">Passwort</span>
        <input type="password" name="password" placeholder="Passwort">
    </div>
    <div class="row">
        <input type="submit" value="Login">
    </div>
</form>