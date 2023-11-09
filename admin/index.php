<?php
session_start();
require_once "./phpFunctions/createToken.php";
require_once "../backend/bdd.php";

if (!isset($_SESSION['connexion'])){
    $_SESSION['connexion'] = 0;
    
} else {
    $_SESSION['connexion'] += 1;
    if ($_SESSION['connexion'] > 3){
        header('Location:forbidenAccess.php');
        exit();
        // bloquer l accés  de cette session 
    }
}

var_dump($_SESSION['connexion']);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    $stmt = $bdd->prepare("SELECT * FROM staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password_hash"])) {
        //verifier le status de  l admin;
        //si === wait alors envoyer sur la page de première connexion firstConnect.php
        //si non
        // Créez un token
        $token = createToken();

        // Calculez la timestamp actuelle + 30 minutes (en secondes)
        $expiration = time() + 1800;//30 minutes

        $_SESSION["log_in"] = true;
        $_SESSION["user_id"] = $user["staff_id"];
        $_SESSION["token"] = $token;
        $_SESSION["user"] = $user["firstname"] . " " . $user["lastname"];
        $_SESSION["admin"] = $user["rights"];

        $sql = $bdd->prepare('UPDATE staff SET token = ?, token_end = ? WHERE staff_id = ?');
        $sql->bind_param("sii", $token, $expiration, $_SESSION['user_id']);
        $sql->execute();
        $_SESSION['connexion'] == 0;

        include_once ("./phpFunctions/insertLog.php");
        insertLog("connexion", $bdd);
        header("Location: dashboard.php"); // Rediriger vers la page d'accueil après la connexion
        exit();
    } else {
        //affichage d'erreur 
        $_SESSION['info'] = "mot de passe ou identifiant incorrect";
        $_SESSION['info-type'] = 'error';
        
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once './phpComponents/head.php'; ?>
    <title>Connexion</title>
</head>

<body>
    <!-- header -->
    <?php 
        include_once './phpComponents/header.php';
        include_once './phpComponents/infos.php';
    ?>

    <!-- main section -->
    <section class="main">
        <div class="sep"></div>
        <div class="connect-form">
            <legend><h2>Connexion</h2></legend>
            <form method="POST" action="index.php" id="connect-form">
                <div class="form-box">
                    <label for="email">Identifiant :</label>
                    <input type="email" name="email" id="email" placeholder="adresse e-mail" required>
                </div>
                <br>
                <div class="form-box">
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" id="password" placeholder="Mot de passe" required>
                </div>
                <br>
                <div class="btn-sub">
                    <input type="submit" name="connexion" id="connexion" value="Se connecter">
                </div>
                <br>
            </form>
            <a href="./mdp_forget.php" style="width: 100%; text-align:center;">Mot de passe oublié</a>
        </div>
        <?php
        
        // scripts
        include_once("./phpComponents/script.php");
        ?>
        <script>
            function onSubmit(token) {
                document.getElementById("connect-form").submit();
            }
        </script>
    </section>
</body>
</html>
