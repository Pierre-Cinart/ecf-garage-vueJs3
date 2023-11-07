<?php


// Vérification de la connexion de l'utilisateur et de son statut admin
if (!isset($_SESSION["log_in"]) || !isset($_SESSION["admin"]) || $_SESSION["admin"] != "y") {
    header('Location: logout.php');
    exit();
}

// Vérification de la valeur du paramètre GET "show"
if (isset($_GET["show"])) {
    $show = $_GET["show"];

    // Vérification de la page actuelle
    $currentPageShow = isset($_GET['page']) ? intval($_GET['page']) : 1; // Si la page n'est pas définie, la page est 1
    $perPage = 10; // Nombre d'éléments par page

    // Calcul de l'offset en fonction de la page actuelle
    $offset = ($currentPageShow - 1) * $perPage;

    if ($show === "logs") {
        // Affichage de la liste des logs

        // Requête SQL pour compter le nombre total de logs
        require_once('../backend/bdd.php'); // Assurez-vous d'inclure correctement le fichier de connexion à la base de données.
        $countQuery = "SELECT COUNT(*) FROM logs";
        $countResult = mysqli_query($bdd, $countQuery);
        $totalLogs = mysqli_fetch_row($countResult)[0];

        // Calcul du nombre total de pages
        $totalPages = ceil($totalLogs / $perPage);

        // Requête SQL pour récupérer les logs de la page actuelle avec jointure pour récupérer les noms et prénoms des administrateurs
        $query = "SELECT logs.*, staff.firstname, staff.lastname 
                  FROM logs 
                  LEFT JOIN staff ON logs.admin_id = staff.staff_id 
                  ORDER BY logs.log_date DESC 
                  LIMIT $perPage OFFSET $offset";
        $result = mysqli_query($bdd, $query);

        // Création d'un tableau pour stocker les logs
        $logBoxes = [];

        // Remplissage du tableau avec les logs
        while ($row = $result->fetch_assoc()) {
            $logBox = [
                'logAction' => $row['action'],
                'date' => 'le : ' . $row['log_date'],
                'adminName' => $row['firstname'] . ' ' . $row['lastname'],
            ];

            $logBoxes[] = $logBox;
        }
    } else {
        // Valeur de "show" non reconnue, rediriger ou afficher un message d'erreur
        header('Location: admin.php'); // Redirigez vers la page par défaut, par exemple
        exit();
    }
} else {
    // Rediriger si le paramètre "show" n'est pas défini
    header('Location: admin.php'); // Redirigez vers la page par défaut, par exemple
    exit();
}
?>

<!-- Début du contenu HTML -->
<div class="logs">
    <?php foreach ($logBoxes as $log) : ?>
        <div class="log-box">
            <div>
                <p class="log-name"><?= $log['adminName'] ?></p>
                <p class="log-date"><?= $log['date'] ?></p>
                <p class="log-action"><?= $log['logAction'] ?></p>
                
            </div>
        </div>
        <div class="sep"></div>
    <?php endforeach; ?>
</div>

<!-- Pagination -->
<div class="pagination">
    <?php
    $linkStatus = "show=logs"; // Vous pouvez ajouter d'autres paramètres GET ici si nécessaire
    $previousPage = $currentPageShow - 1;
    $nextPage = $currentPageShow + 1;
    $hasPreviousPage = ($currentPageShow > 1);
    $hasNextPage = ($currentPageShow < $totalPages);

    if ($hasPreviousPage) {
        echo '<a href="admin.php?' . $linkStatus . '&page=' . $previousPage . '">Page précédente</a>';
    }
    echo '<p>' . $currentPageShow . '</p>';
    if ($hasNextPage) {
        echo '<a href="admin.php?' . $linkStatus . '&page=' . $nextPage . '">Page suivante</a>';
    }
    ?>
</div>

<!-- Fin du contenu HTML -->
