<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../backend/bdd.php";
    include_once "./phpFunctions/createToken.php";
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    $stmt = $bdd->prepare("SELECT * FROM staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password_hash"])) {
        $_SESSION["log_in"]=true;
        $_SESSION["user_id"] = $user["staff_id"];
        $_SESSION["Token"] = createToken();
        $_SESSION["user"] = $user["firstname"] . " " . $user["name"];
        $_SESSION["admin"] = $user["admin"];
        $sql = $bdd->prepare('UPDATE staff SET token= ? WHERE staff_id = ?');
        $sql->bind_param("si", $_SESSION["Token"], $_SESSION['user_id']);
        $sql->execute();

        header("Location: dashboard.php"); // Rediriger vers la page d'accueil après la connexion
        exit;
    } else {
        $error = "Identifiants incorrects";
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
    <?php include_once './phpComponents/header.php'; ?>

    <!-- main section -->
    <section class="main">
        <div class="sep"></div>
        <div class="connect-form">
            <legend><h2>Connexion</h2></legend>
            <form method="POST" action="">
                <div class="form-box">
                    <label for="email">Identifiant :</label>
                    <input type="email" name="email" id="email" placeholder=" adresse e-mail">
                </div>
                <br>
                <div class="form-box">
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" id="password" placeholder="Mot de passe">
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
        if (isset($erreurConnexion)) {
            echo '<p class="error-mess">' . $erreurConnexion . '</p>';
        }
        
    //        scripts
    include_once("./phpComponents/script.php")
    ?>




</body>
</html>
