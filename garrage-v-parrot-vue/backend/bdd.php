<?php
  $host_name = 'localhost';
  $database = 'vparrot';
  $user_name = 'root';
  $password = 'Critical+59200';

  $bdd = new mysqli($host_name, $user_name, $password, $database);

  if ($bdd->connect_error) {
    die('<p>La connexion au serveur MySQL a échoué: '. $bdd->connect_error .'</p>');
  } 
 
 
?>