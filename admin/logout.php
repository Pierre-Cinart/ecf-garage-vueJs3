<?php
session_start();
if (isset($_SESSION['user_id'])) {
    require_once("../backend/bdd.php");
    include_once ("./phpFunctions/insertLog.php");
    insertLog("deconnexion", $bdd);
}

// Détruire la session après avoir enregistré le log
if (isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
}
session_unset();
session_destroy();
header('location:index.php');
$_SESSION['info'] = $info;
$_SESSION['info-type'] = 'error';
exit();
?>