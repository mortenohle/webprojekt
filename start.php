
<div class='startintro'>
<h1>Webprojekt Startseite</h1>
<p>Das ist die Startseite. Test</p>
</div>

<div class="pwrapper">

<?php
include_once('db/connect.php');

$sql = "SELECT * FROM products ORDER BY id ASC";

foreach ($con->query($sql) as $row) {
    echo "<div class='box'>";
    echo "<div class='imagebox'><img class='pplaceholder' src='https://dummyimage.com/mediumrectangle/222222/eeeeee' alt='product placeholder'>
<div class='imageoverlay'>
<div class='overlaycontent'>Das Produkt</div>

</div></div>";
    echo "<div class='pdesc'><span class='ptitle'>".$row['name']."</span><br><span class='pprice'>".$row['price']." €</span></div>";
    echo "</div>";
}
?>
</div>
