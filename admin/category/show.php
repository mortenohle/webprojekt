<?php
    include_once('../db/connect.php');
?>

<h1>Kategorien</h1>

<div class="row-full-width">
    <a class="btn-link" href="index.php?page=category&action=new">Kategorie hinzufügen</a>

    <div class="category-row heading">
        <div class="category-col">
            ID
        </div>
        <div class="category-col">
            Name
        </div>
        <div class="category-col">

        </div>
    </div>

    <?php
    $sql_cat = "SELECT * FROM categories";
    foreach ($con->query($sql_cat) as $row_cat) {
        echo "
        <div class='category-row'>
            <div class='category-col'>".$row_cat["id"]."</div>
            <div class='category-col'>".$row_cat["name"]."</div>
            <div class='category-col actions'><span><a href='index.php?page=category&action=edit&id=".$row['id']."'><i class='fa fa-pencil' aria-hidden='true'></i></a></span><span><i class='fa fa-trash' aria-hidden='true'></i></span></div>
        </div>
        ";
    }
    ?>

</div>