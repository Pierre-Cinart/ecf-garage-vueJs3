<?php
session_start();
$currentPage = 'addAdmin';
if (!$_SESSION["log_in"] || $_SESSION["admin"] !="y"){
    header('Location:index.php');
    exit();
}


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
                    <label for="firstname">Prénom :</label>
                    <input type="firstname" name="firstname" id="firstname" placeholder="Prénom"required>
                </div>
                <br>
                <div class="form-box">
                    <label for="name">Nom :</label>
                    <input type="name" name="name" id="name" placeholder="Nom"required>
                </div>
                <br>
                <div class="form-box">
                    <label for="email">Identifiant :</label>
                    <input type="email" name="email" id="email" placeholder=" adresse e-mail"required>
                </div>
                <br>
                <div class="form-box">
                    <label for="confirm_email">Confirm E-mail :</label>
                    <input type="email" name="confirm_email" placeholder=" confirmation de l' e-mail" required>
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
