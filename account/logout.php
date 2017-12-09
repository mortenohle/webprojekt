<?php
session_start();
session_destroy();
$location = "<script>window.location = 'index.php';</script>";
echo $location;
exit;