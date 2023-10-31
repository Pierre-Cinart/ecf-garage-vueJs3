<?php
// Redirige vers la page de déconnexion si l'utilisateur n'est pas connecté
if (!isset($_SESSION["log_in"]) || !isset($_SESSION["comments"])) {
    header('Location: logout.php');
    exit();
}

// Récupère le statut des commentaires depuis la session (doit être "ok" ou "wait")
$commentsStatus = $_SESSION["comments"];

// Détermine la page actuelle
$currentPageShow = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = 5; // Nombre de commentaires par page

// Calcule l'offset en fonction de la page actuelle
$offset = ($currentPageShow - 1) * $perPage;

// Requête SQL pour compter le nombre total de commentaires avec le statut correspondant
$countQuery = "SELECT COUNT(*) FROM comments WHERE comment_status = '$commentsStatus'";
$countResult = mysqli_query($bdd, $countQuery);
$totalComments = mysqli_fetch_row($countResult)[0];

// Calcule le nombre total de pages
$totalPages = ceil($totalComments / $perPage);

// Requête SQL pour récupérer les commentaires de la page actuelle
$query = "SELECT * FROM comments WHERE comment_status = '$commentsStatus' LIMIT $perPage OFFSET $offset";
$result = mysqli_query($bdd, $query);

// Affiche les commentaires
while ($row = $result->fetch_assoc()) {
    // Affiche chaque commentaire dans votre HTML
    echo '<div class="comment-box">';
    echo '<p class="comment-name">' . $row['firstname'] .' '. $row['lastname'] . '</p>';
    echo '<p class="comment-date"> le : ' . $row['comment_date'] . '</p>';
    echo '<div class="comment-box">';
    echo '<p class="comment-text">' . $row['comment_text'] . '</p>';
    echo '</div>';
    echo '</div>';
}

// Liens de pagination (page précédente et page suivante)
$previousPage = $currentPageShow - 1;
$nextPage = $currentPageShow + 1;

// Vérifie s'il y a une page précédente
$hasPreviousPage = ($currentPageShow > 1);

// Vérifie s'il y a une page suivante
$hasNextPage = ($currentPageShow < $totalPages);

echo '<div class="pagination">';
if ($commentsStatus == "ok") {
    $linkStatus = "ok=1";
} elseif ($commentsStatus == "wait") {
    $linkStatus = "wait=1";
}
if ($hasPreviousPage) {
    echo '<a href="adminComments.php?' . $linkStatus . '&page=' . $previousPage . '">Page précédente</a>';
}
echo '<p>' . $currentPageShow . '</p>';
if ($hasNextPage) {
    echo '<a href="adminComments.php?' . $linkStatus . '&page=' . $nextPage . '">Page suivante</a>';
}
echo '</div>';
?>
