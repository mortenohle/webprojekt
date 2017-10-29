
<div class='startintro'>
<h1>Webprojekt Startseite</h1>
<p>Das ist die Startseite. Test</p>
</div>

<div class="pwrapper">

<?php
include_once('db/connect.php');

$sql = "SELECT * FROM products ORDER BY id ASC";

foreach ($con->query($sql) as $row) {
    //placeholder abfrage
    if (!empty($row['img'])) {
        $imgurl = $row['img'];}
    else {
        $imgurl = "placeholder.jpg";
    }

    echo "<div class='box'>";
    echo "<div class='imagebox'><img class='pplaceholder' src='images/products/".$imgurl."' alt='product placeholder'>
<div class='imageoverlay'>
<div class='overlaycontent'><a href='index.php?page=product&product=show&id=".$row['id']."'>Details</a></div>

</div></div>";
    echo "<div class='pdesc'><a class='ptitle' href='index.php?page=product&product=show&id=".$row['id']."'>".$row['name']."</a><br><span class='pprice'>".$row['price']." €</span></div>";
    echo "</div>";
}
?>
</div>
