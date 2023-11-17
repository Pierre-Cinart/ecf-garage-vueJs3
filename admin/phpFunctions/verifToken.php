<?php
// Vérifiez si l'utilisateur est connecté
if (!$_SESSION["log_in"]) {
    header('Location: logout.php');
    exit();
}
//verification de demande de connexion
if ( $_SESSION['connexion'] > 0) {
    include_once ('./phpFunctions/verifPassword.php');
}
// Récupérer l'ID de l'utilisateur depuis la session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Vérifier si le jeton existe dans la session et mettre à zéro la validation du token (0=non validé , 1=validé)
    if (isset($_SESSION['token'])) {
        $token = $_SESSION['token'];
        $_SESSION['validateToken'] = 0;
    } else {
        $_SESSION['info'] = "Une erreur est survenue. Veuillez vous connecter.";
        $_SESSION['info-type'] = 'error';
        header('Location: logout.php');
        exit();
    }
} else {
    $_SESSION['info'] = "Une erreur est survenue. Veuillez vous connecter.";
    $_SESSION['info-type'] = 'error';
    header('Location: logout.php');
    exit();
}

// Préparer la requête pour récupérer le jeton de l'utilisateur depuis la base de données
$queryToken = $bdd->prepare("SELECT token FROM staff WHERE staff_id = ?");
$queryToken->bind_param("i", $userId);
$queryToken->execute();
$resultToken = $queryToken->get_result();
$tokenUser = $resultToken->fetch_assoc();

// Vérifier si le jeton de session correspond au jeton enregistré dans la base de données
if ($tokenUser && $_SESSION['token'] === $tokenUser['token']) {
    // Le token est valide, vérifions si le timestamp n'a pas expiré

    // Récupérer la date actuelle
    $currentTimestamp = time();

    // Préparer la requête pour récupérer la valeur de "token_end" depuis la base de données
    $queryTokenEnd = $bdd->prepare("SELECT token_end FROM staff WHERE staff_id = ?");
    $queryTokenEnd->bind_param("i", $userId);
    $queryTokenEnd->execute();
    $resultTokenEnd = $queryTokenEnd->get_result();
    $tokenEnd = $resultTokenEnd->fetch_assoc();

    // Vérifier si le token est valide et n'a pas expiré
    if ($tokenEnd && $currentTimestamp < $tokenEnd['token_end']) {
        // Le token est valide et n'a pas expiré

        // Mettre à jour le timestamp de "token_end" 
        $queryUpdateTokenEnd = $bdd->prepare("UPDATE staff SET token_end = ? WHERE staff_id = ?");
        $newTokenEnd = time() + 1800; // 30 minutes
        $queryUpdateTokenEnd->bind_param("ii", $newTokenEnd, $userId);

        if ($queryUpdateTokenEnd->execute()) {
            $_SESSION['validateToken'] = 1;//token validé
            // Le timestamp du token a été mis à jour avec succès
            // la demande administrateur peut etre effectuée
        } else {
            // Échec de la mise à jour du timestamp du token
            $_SESSION['info'] = 'une erreur est survenue veuillez vous reconnecter';
            header('Location: logout.php');
            exit();
        }
    } else {
        // Le token a expiré, rediriger vers reconnexion
        
        echo 'verifier le mot de passe';
        include_once('./phpFunctions/verifPassword.php');
        
    }
} else {
    // Les jetons ne correspondent pas, rediriger vers logout.php
    header('Location: logout.php');
    exit();
}

