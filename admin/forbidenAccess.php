<?php
session_start();
var_dump($_SESSION['connexion']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>
        vous avez dépassé le nombre de tentatives de connexion <br>
        <a href="contactAdmin.php">contactez un chef administrateur</a> ou <a href="resetPassword.php"></a> <br>
       
    </p>
</body>
</html>


