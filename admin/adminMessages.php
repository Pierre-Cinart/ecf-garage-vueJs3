<?php
session_start();
$currentPage = 'adminMessages';

if (!$_SESSION["log_in"]) {
    header('Location: logout.php');
    exit();
}

// Inclure le fichier de connexion à la base de données
require_once('../backend/bdd.php');

// Requête SQL pour compter les messages en attente de traitement et les messages validés
$queryMessages = "SELECT message_status, COUNT(*) AS count FROM messages GROUP BY message_status";
$resultMessages = mysqli_query($bdd, $queryMessages);
$messages = [];
$messagesWait = 0;
$messagesOk = 0;

while ($row = mysqli_fetch_assoc($resultMessages)) {
    $messages[$row['message_status']] = $row['count'];
    if ($row['message_status'] === 'wait') {
        $messagesWait = $row['count'];
    } elseif ($row['message_status'] === 'ok') {
        $messagesOk = $row['count'];
    }
}

// Gérer les paramètres GET pour afficher les messages correspondants
if (!isset($_GET["ok"]) || (isset($_GET["ok"]) && $_GET["ok"] != 1)) {
    $ok = 0;
}
if (isset($_GET["ok"]) && $_GET["ok"] == 1) {
    $ok = 1;
}
if (!isset($_GET["wait"]) || (isset($_GET["wait"]) && $_GET["wait"] != 1)) {
    $wait = 0;
}
if (isset($_GET["wait"]) && $_GET["wait"] == 1) {
    $wait = 1;
}
// Requête SQL pour compter les commentaires en attente de traitement
$querymessages = "SELECT COUNT(*) FROM messages WHERE message_status = 'wait'";
$resultmessages = mysqli_query($bdd, $querymessages);
$messagesWait = mysqli_fetch_array($resultmessages)[0];

// Requête SQL pour compter les commentaires validés
$querymessagesOk = "SELECT COUNT(*) FROM messages WHERE message_status = 'ok'";
$resultmessagesOk = mysqli_query($bdd, $querymessagesOk);
$messagesOk = mysqli_fetch_array($resultmessagesOk)[0];

// Total des commentaires
$messagesTotal = $messagesOk + $messagesWait;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once("./phpComponents/head.php"); ?>
    <title>Gestion des messages</title>
</head>
<body>
    <?php include_once("./phpComponents/header.php"); ?>
    <div class="connect-info">
        <div class="btn-connect"></div>
        <p>Connecté en tant que <?php echo $_SESSION["user"]; ?></p>
    </div>
    <div class="dashboard-info">
        <!-- Afficher un bouton Commentaires à traiter et un bouton Commentaires validés -->
        <p><a href="./adminMessages.php?wait=1"><?php echo "Messages à traiter : " . $messagesWait; ?></a></p>
        <p><a href="./adminMessages.php?ok=1"><?php echo "Messages traités : " . $messagesOk; ?></a></p>
        <!-- Gérer l'affichage avec pagination lors du clic + flèches de retour en haut et en bas de la div -->
    </div>
    <div id="show-list">
        <?php
      
            if ($ok == 1) {
                $_SESSION['messages'] = "ok";
                echo "Commentaires validés : ";
                include_once('./phpFunctions/showMessages.php');
                // Afficher ici les commentaires validés
            } elseif ($wait == 1) {
                $_SESSION['messages'] = "wait";
                echo "Commentaires à traiter : ";
                include_once('./phpFunctions/showMessages.php');
                // Afficher ici les commentaires à traiter
            }
        ?> 
    </div>
    <?php include_once("./phpComponents/script.php"); ?>
</body>
</html>
