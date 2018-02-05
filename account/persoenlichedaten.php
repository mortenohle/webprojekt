<?php
if(isset($_SESSION["username"])) {
$id = $_SESSION["userid"];

include_once("db/connect.php");

$sql = $con->prepare("SELECT * FROM user WHERE id = :id");
$sql->bindParam(':id', $id); // Variable wird auf stmt noch hinzugefügt: Variable=E-Mail-Adresse
$sql->execute(); // Abfrage ausführen
$row = $sql->fetch(PDO::FETCH_ASSOC);

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


    <div class="content_kundenkonto">

     <form action="index.php?page=account&action=profileupdate" method="post">
         <div class="persoenlichedaten">
             <h2>Persönliche Daten</h2>

             <span class="input-heading">Vorname</span>
             <input id="vorname" name="vorname" type="text" placeholder="Vorname" value="<?php echo $row["firstname"]; ?>">

             <span class="input-heading">Nachname</span>
             <input id= "nachname" type="text" name="nachname" placeholder="Nachname" value="<?php echo $row["lastname"]; ?>">

             <span class="input-heading">Passwort</span>
             <input id="pass" name="passwort" type="password" maxlength="15" placeholder="Dein neues Passwort">

             <span class="input-heading">Passwort wiederholen</span>
             <input id="pass" name="passwort_wiederholen" type="password" maxlength="15" placeholder="Wiederhole dein neues Passwort">
        </div>

        <div class="persoenlichedaten adresse">
            <h2>Liefer-/Rechnungsadresse</h2>

            <span class="input-heading">Straße, Nr.</span>
            <input type="text" id="adresse" name="adresse" placeholder="Straße, Nr." value="<?php echo $row["address"]; ?>">

            <span class="input-heading">PLZ</span>
            <input type="text" id="plz" name="plz" placeholder="PLZ" <?php if ($row["postcode"] != 0) { echo "value='".$row["postcode"]."'";}?>>

            <span class="input-heading">Ort</span>
            <input type="text" id="ort" name="ort" placeholder="Ort" value="<?php echo $row["city"]; ?>">

            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Änderungen speichern">
        </div>

    </form>
</div>

</div>
<?php } else { ?>
    <p style="padding-bottom: 20px;">Du musst angemeldet sein, um diese Seite sehen zu können!</p>
    <a class="btn-link" href="index.php?page=account&action=login">Zur Anmeldung!</a>
<?php } ?>