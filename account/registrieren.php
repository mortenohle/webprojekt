<div class="registrierungsbox">
    <h1>Registrierung</h1>

    <form action="index.php?page=account&action=speichern" method="post">

    <span class="input-heading">Vorname</span>
    <input id="vorname" name="vorname" type="text" placeholder="Vorname*">

    <span class="input-heading">Nachname</span>
    <input id= "nachname" type="text" name="nachname"placeholder="Nachname*">

    <span class="input-heading">E-Mail-Adresse</span>
    <input id="e_mail" name="e_mail" placeholder="E-Mail-Adresse*" type="email" class="input-wdh">
    <input id="e_mail2" name="e_mail_wiederholen" placeholder="Wiederhole deine E-Mail-Adresse*" type="email">

    <span class="input-heading">Passwort</span>
    <input id="pass" name="passwort" type="password" maxlength="15" placeholder="Dein Passwort*" class="input-wdh">

    <input id="pass" name="passwort_wiederholen" type="password" maxlength="15" placeholder="Wiederhole dein Passwort*">

    <p>
        Dein Passwort muss mindestens 8 Zeichen umfassen. Berücksichtige Groß- und Kleinschreibung.<br><br>
    </p>

    <input type="submit" name="Jetzt anmelden" value="Jetzt Registrieren">
    <p>* hierbei handelt es sich um ein Pflichtfeld</p>
</form>
</div>
