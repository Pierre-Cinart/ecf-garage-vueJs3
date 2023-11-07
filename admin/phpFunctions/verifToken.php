<?php
if (!$_SESSION["log_in"] ){
    header('Location:logout.php');
    exit();
}
// Récupérer le jeton de l'utilisateur depuis la base de données
// AJOUTER UN TEST SUR LE TIMESTAMP ET LANC2 UNE FONCTION D IDENTIFICATION SI LE TEMPS EST DEPASSé
    // tester l id de l utilisateur / deconnexion si vide deconnecter
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        if (isset($_SESSION['token'])) {
            $token = $_SESSION['token'];
        } else { header('Location:logout.php');
            exit();
        }
    } else {  
        header('Location:logout.php');
        exit();
    }

$queryToken = $bdd->prepare("SELECT token FROM staff WHERE staff_id = ?");
$queryToken->bind_param("i", $userId);
$queryToken->execute();
$resulttToken = $queryToken->get_result();
$tokenUser = $resulttToken->fetch_assoc();

if ($tokenUser && $_SESSION['token'] === $tokenUser['token']) {
   
} else {
    header('Location:logout.php');
    exit();
}
    



