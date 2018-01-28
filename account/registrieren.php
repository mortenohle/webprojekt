<div class="registrierungsbox">
    <h1>Registrierung</h1>

    <form action="speichern.php" method="post">
        <p>Anrede</p>
        <select name="geschlecht">
            <option>Frau</option>
            <option>Mann</option>
        </select>
        <br><br>

        <input id="vorname" name="vorname" type="text" placeholder="Vorname*">

        <input id= "nachname" type="text" name="nachname"placeholder="Nachname*">
        <p>E-Mail-Adresse</p>
        <input id="e_mail" name="e_mail" placeholder="E-Mail-Adresse*" type="email">
        <input id="e_mail2" name="e_mail_wiederholen" placeholder="Wiederhole deine E-Mail-Adresse*" type="email">
        <p>
        <p>Passwort</p>
        <input id="pass" name="passwort" type="password" maxlength="15" placeholder="Dein Passwort*">
        </p>
        <p>
            <input id="pass" name="passwort_wiederholen" type="password" maxlength="15" placeholder="Wiederhole dein Passwort*">
        </p>
        <p>
            Dein Passwort muss mindestens 8 Zeichen umfassen.<br>
            Berücksichtige Groß- und Kleinschreibung.<br><br>
        </p>
        <p>
            <input id="telefon" name="telefon" type="text" placeholder="Telefon">
        </p>
        <p><h4>Geburtstdatum</h4></p>
        <input type="date" id="gebdat" name="gebdat">
        <p>
        <p><h4>Rechnungsadresse</h4></p>
        <p>
            <input type="text"id="adresse"name="adresse"placeholder="Straße und Hausnummer.*">
        </p>
        <p>
            <input type="text" id="adresse1" name="adresse1" placeholder="Adresszusatz (optional)">
            <input type="text" id="plz"name="plz" placeholder="PLZ*">
            <input type="text" id="ort"name="ort"placeholder="Ort*">
            <input type="submit" name="Jetzt anmelden" value="Jetzt Registrieren">
        <p>* Hierbei handelt es sich um ein Pflichtfeld</p>
    </form>
</div>