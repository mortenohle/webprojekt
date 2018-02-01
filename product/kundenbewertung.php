<div class="loginbox">
<?php
$id = $_GET['id'];
if(isset($_SESSION["username"])) {
?>

    <h1>Wie gefällt dir das Produkt?</h1>
    <form action="index.php?page=product&product=ratesuccess" method="post">
        <span class="input-heading">Qualität der Ware</span>
        <select name="qualitaet">
            <option>Bitte wählen</option>
            <option>sehr gut</option>
            <option>gut</option>
            <option>befriedigend</option>
            <option>ausreichend</option>
            <option>mangelhaft</option>
        </select>
        <span class="input-heading">Verpackung/Versand</span>
        <select name="versand">
            <option>Bitte wählen</option>
            <option>sehr gut</option>
            <option>gut</option>
            <option>befriedigend</option>
            <option>ausreichend</option>
            <option>mangelhaft</option>
        </select>
        <span class="input-heading">Passform</span>
        <select name="passform">
            <option>Bitte wählen</option>
            <option>sehr gut</option>
            <option>gut</option>
            <option>befriedigend</option>
            <option>ausreichend</option>
            <option>mangelhaft</option>
        </select>
        <span class="input-heading">Preis-/Leistung</span>
        <select name="leistung">
            <option>Bitte wählen</option>
            <option>sehr gut</option>
            <option>gut</option>
            <option>befriedigend</option>
            <option>ausreichend</option>
            <option>mangelhaft</option>
        </select>
        <span class="input-heading">Kundenkommentar</span>
        <textarea name="kommentar" placeholder="Hinterlasse uns eine Nachricht"></textarea>
        <br><br>
        <input type="hidden" name="produkt_id" value="<?php echo $id; ?>">
        <input type="submit" value="Bewertung abgeben!">
    </form>

<?php } else { ?>

    <h1>Bitte anmelden!</h1>
    <p>Du musst angemeldet sein, um ein Produkt bewerten zu können!</p>
    <a class="btn-link fw" href="index.php?page=account&action=login">Zur Anmeldung!</a>

<?php } ?>
</div>