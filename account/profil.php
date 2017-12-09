<h1>Mein Profil</h1>

<?php if(isset($_SESSION["username"])) { ?>

    <p>Inhalt folgt!</p>

<?php } else { ?>

    <p style="padding-bottom: 20px;">Du musst angemeldet sein, um diese Seite sehen zu können!</p>
    <a class="btn-link">Zur Startseite</a>

<?php } ?>
