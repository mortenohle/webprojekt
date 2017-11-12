<?php
    session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Adminbereich</title>
    <link href="css/style-admin.css" type="text/css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/backend.js"></script>
</head>

<body>
<div id="admin-login-wrapper">

<div id="admin-form-login-wrapper">
    <div class="form-logo">Logo</div>
    <?php include("session/login-form.php"); ?>
</div>
</div>

</body>