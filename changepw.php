<?php
include_once("db/connect.php"); 
$result = mysql_query("SELECT *from user WHERE userid='" . $_SESSION["userid"] . "'");
$row=mysql_fetch_array($result);
if($_POST["currentPassword"] == $row["pw"]) {
mysql_query("UPDATE users set password='" . $_POST["newPassword"] . "' WHERE userid='" . $_SESSION["userid"] . "'");
$message = "Password Changed";
} else $message = "Current Password is not correct";
}
?>