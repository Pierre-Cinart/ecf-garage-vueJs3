<?php
session_start();
$currentPage = 'adminMessages';

if (!isset($_SESSION["log_in"])) {
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
$wait = isset($_GET['wait']) && $_GET['wait'] == 1 ? 1 : 0;
$ok = isset($_GET['ok']) && $_GET['ok'] == 1 ? 1 : 0;
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
        <!-- Boutons Messages à traiter / Messages validés -->
        <p><a href="./adminMessages.php?wait=1&ok=0"><?php echo "Messages à traiter : " . $messagesWait; ?></a></p>
        <p><a href="./adminMessages.php?wait=0&ok=1"><?php echo "Messages traités : " . $messagesOk; ?></a></p>
    </div>
    <div id="show-list">
        <!-- Gérer l'affichage des Messages ici (pagination, etc.) -->
        <?php
        if ($ok === 1) {
            echo "Messages validés : ";
            // Afficher ici les messages validés
        } elseif ($wait === 1) {
            echo "Messages à traiter : ";
            // Afficher ici les messages à traiter
        }
        ?>
    </div>
    <?php include_once("./phpComponents/script.php"); ?>
</body>
</html>
