<?php
session_start();
$currentPage = 'admin';

if (!$_SESSION["log_in"] || $_SESSION["admin"] == "n") {
    header('Location: logout.php');
    exit();
}

require_once("../backend/bdd.php");
require_once("./phpFunctions/createToken.php");

if (isset($_POST['inscription'])) {
    if (!empty($_POST['new-user']) && !empty($_POST['new-user-2']) && !empty($_POST['firstname']) && !empty($_POST['lastname'])) {
        if ($_POST['new-user'] === $_POST['new-user-2']) {
            $email = $_POST['new-user'];
            
            // Vérifier si l'adresse e-mail existe déjà
            $checkQuery = "SELECT email FROM staff WHERE email = ?";
            $stmtCheck = mysqli_prepare($bdd, $checkQuery);
            mysqli_stmt_bind_param($stmtCheck, "s", $email);
            mysqli_stmt_execute($stmtCheck);
            mysqli_stmt_store_result($stmtCheck);

            if (mysqli_stmt_num_rows($stmtCheck) > 0) {
                $_SESSION['info'] = "L'adresse e-mail existe déjà.";
                $_SESSION['info-type'] = "error";
            } else {
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $token = createToken();
                $password = password_hash('V-Parrot+2023', PASSWORD_DEFAULT);

                $insertQuery = "INSERT INTO staff (firstname, lastname, email, rights, token, password_hash) VALUES (?, ?, ?, 'wait', ?, ?)";
                $stmtInsert = mysqli_prepare($bdd, $insertQuery);
                mysqli_stmt_bind_param($stmtInsert, "sssss", $firstname, $lastname, $email, $token, $password);
                mysqli_stmt_execute($stmtInsert);

                if (mysqli_stmt_affected_rows($stmtInsert) > 0) {
                    $_SESSION['info'] = "Inscription réussie.";
                    $_SESSION['info-type'] = "success";
                    header('Location: admin.php');
                    exit();
                } else {
                    $_SESSION['info'] = "Erreur lors de l'inscription : " . mysqli_error($bdd);
                    $_SESSION['info-type'] = "error";
                }
            }
        } else {
            $_SESSION['info'] = "Les adresses e-mail ne correspondent pas.";
            $_SESSION['info-type'] = "error";
        }
    } else {
        $_SESSION['info'] = "Tous les champs doivent être remplis.";
        $_SESSION['info-type'] = "error";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once('./phpComponents/head.php'); ?>
    <title>Inscription</title>
</head>

<body>
    <?php 
        include_once("./phpComponents/header.php"); 
        include_once('./phpComponents/infos.php');
    ?>

    <div class="text-sub">
        <div class="sep"></div>
    </div>

    <?php
    if (isset($erreurInscription) && !empty($erreurInscription)) {
        echo '<p class="error-mess">' . $erreurInscription . '</p>';
    }
    ?>

    <div class="sep"></div>

    <div class="connect-form">
        <h2>Inscription</h2>
        <form method="POST" action="addAdmin.php">
            <div class="form-box">
                <label for="firstname">Prénom :</label>
                <input type="text" name="firstname" id="firstname" placeholder="Entrez votre prénom" required>
            </div>
            <br>
            <div class="form-box">
                <label for="lastname">Nom :</label>
                <input type="text" name="lastname" id="lastname" placeholder="Entrez votre nom" required>
            </div>
            <br>
            <div class="form-box">
                <label for="new-user">E-mail :</label>
                <input type="email" name="new-user" id="new-user" placeholder="Entrez votre adresse e-mail" required>
            </div>
            <br>
            <div class="form-box">
                <label for="new-user-2">Confirmez l'e-mail :</label>
                <input type="email" name="new-user-2" id="new-user-2" placeholder="Entrez votre adresse e-mail " required>
            </div>
            <br>

            <br>
            <div class="btn-sub">
                <input type="submit" name="inscription" id="inscription" value="Créer un compte" onclick="return validateForm()">
            </div>
            <br>
        </form>
    </div>

    <div class="sep"></div>

    <?php include_once('./phpComponents/script.php'); ?>

</body>

</html>
