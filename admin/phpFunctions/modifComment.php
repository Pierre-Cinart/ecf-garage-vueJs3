<?php
session_start();
// à faire cacher le formulaire si aucun article n 'est selectionné
//deconnexion automatique si user non autorisé
if (!isset($_SESSION["log_in"])){
    header('Location:logout.php');
    exit();
}
$currentPage = 'adminArticles'; //nom de page pour la navBar
// accés bdd
require_once("../../backend/bdd.php");