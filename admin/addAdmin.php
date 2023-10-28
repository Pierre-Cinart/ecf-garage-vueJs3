<?php
session_start();
$currentPage = 'addAdmin';
if (!$_SESSION["log_in"] || $_SESSION["admin"] !="y"){
    header('Location:index.php');
    exit();
}
//verifier si les données post existent les traiter et renvoyer un message d 'info
//renvoyer vers admin.php si succés , ou signaler l ' erreur si les posts sont set 
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php include_once ("./phpComponents/head.php");?>
    <title>Ajout de personnel</title>
</head>
<body>
<?php include_once ("./phpComponents/header.php");?>
   <div class="connect-info">
    <div class = "btn-connect"></div>
    <p>connecté en tant que <?php echo $_SESSION["user"]?></p>
   </div>
   

   <div class="admin-form">
            <legend><h2>Inscription du personnel</h2></legend>
            <form method="POST" action="addAdmin.php">
                <div class="form-box">
                    <label for="email">Identifiant :</label>
                    <input type="email" name="email" id="email" placeholder=" adresse e-mail">
                </div>
                <br>
                <div class="form-box">
                    <label for="firstname">Prénom :</label>
                    <input type="firstname" name="firstname" id="firstname" placeholder="Prénom">
                </div>
                <br>
                <div class="form-box">
                    <label for="name">Nom :</label>
                    <input type="name" name="name" id="name" placeholder="Nom">
                </div>
                <br>
                <div class="btn-sub">
                    <input type="submit" name="subscribe" id="subscribe" value="Enregistrer">
                </div>
                <br>
            </form>
           
        
        <?php
        if (isset($erreurConnexion)) {
            echo '<p class="error-mess">' . $erreurConnexion . '</p>';
        }
        
    //        scripts
    include_once("./phpComponents/script.php")
    ?>




</body>
</html>
    <!-- redirige vers un formulaire d 'inscription du personnel addAmin.php -->

   </div>
   <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
