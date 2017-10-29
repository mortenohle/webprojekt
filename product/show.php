<?php
$id = $_GET['id'];
include_once('db/connect.php');

$sql = "SELECT * FROM products WHERE id = ".$id;
$prod =$con->query($sql);
$result = $prod->fetch();
//placeholder abfrage
if (!empty($result['img'])) {
    $imgurl = $result['img'];}
else {
    $imgurl = "placeholder.jpg";
}
?>
<div class="col2">
    <div class="box">
      <img class="prod_image" src="images/products/<?php echo $imgurl; ?>">
    </div>
    <div class='box'>
        <div class="prod_right">
            <span class="prod_title"><?php echo $result["name"]; ?></span><br>
            <span class="prod_price"><?php echo $result["price"]; ?> €</span><br>
            <span class="prod_desc"><?php echo $result["desc"]; ?></span><br>


        </div>

    </div>


</div>