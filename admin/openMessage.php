<?php
    session_start();
    //verification du token 
  include_once("./phpFunctions/verifToken.php");
  if ($_SESSION['validateToken'] != 1){
      header('Location: logout.php');
      exit();
  }
?>

ouvrir le message //
donner la possibilité de repondre ou supprimer //
changer le status ou effacer //
enregistrer la réponse  //
assigner un code permetant de consulter le message pour que l utilisateur puisse le reconsulter  //
afficher un message de succé ou d Erreur //
(ne pas oublier d implementé une fonction qui empeche d envoyer plusieurs messages à la chaine) //
revoir l enregistrement des messages pour ajout des dates

