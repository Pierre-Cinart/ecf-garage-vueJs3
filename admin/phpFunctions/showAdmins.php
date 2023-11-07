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

    if ($show === "admins") {
        // Affichage de la liste des administrateurs

        // Requête SQL pour compter le nombre total d'administrateurs
        require_once('../backend/bdd.php'); // Assurez-vous d'inclure correctement le fichier de connexion à la base de données.
        $countQuery = "SELECT COUNT(*) FROM staff";
        $countResult = mysqli_query($bdd, $countQuery);
        $totalAdmins = mysqli_fetch_row($countResult)[0];

        // Calcul du nombre total de pages
        $totalPages = ceil($totalAdmins / $perPage);

        // Requête SQL pour récupérer les administrateurs de la page actuelle
        $query = "SELECT * FROM staff ORDER BY admin_date DESC LIMIT $perPage OFFSET $offset";
        $result = mysqli_query($bdd, $query);

        // Création d'un tableau pour stocker les administrateurs
        $adminBoxes = [];

        // Remplissage du tableau avec les administrateurs
        while ($row = $result->fetch_assoc()) {
            $adminBox = [
                'name' => $row['firstname'] . ' ' . $row['lastname'],
                'date' => 'le : ' . $row['admin_date'],
                'adminId' => $row['staff_id']
            ];

            $adminBoxes[] = $adminBox;
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
<div class="admins">
    <?php foreach ($adminBoxes as $admin) : ?>
        <div class="admin-box">
            <div>
                <p class="admin-name"><?= $admin['name'] ?></p>
                <p class="admin-date"><?= $admin['date'] ?></p>
            </div>

            <div class="comment-ico">
                <!-- Utilisez la fonction confirmDelete pour supprimer l'administrateur -->
                <button class="icon-button bg-red" onclick="confirmDelete('deleteAdmin.php', <?= $admin['adminId'] ?>)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        <div class="sep"></div>
    <?php endforeach; ?>
</div>

<!-- Pagination -->
<div class="pagination">
    <?php
    $linkStatus = "show=admins"; // Vous pouvez ajouter d'autres paramètres GET ici si nécessaire
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
