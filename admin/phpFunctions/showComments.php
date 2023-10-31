<?php
// Redirige vers la page de déconnexion si l'utilisateur n'est pas connecté
if (!isset($_SESSION["log_in"]) || !isset($_SESSION["comments"])) {
    header('Location:logout.php');
    exit();
}

// Récupère le statut des commentaires depuis la session (doit être "ok" ou "wait")
$commentsStatus = $_SESSION["comments"];

// Détermine la page actuelle
$currentPageShow = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = 5; // Nombre de commentaires par page

// Calcule l'offset en fonction de la page actuelle
$offset = ($currentPageShow - 1) * $perPage;

// Requête SQL pour récupérer les commentaires de la page actuelle
$query = "SELECT * FROM comments WHERE comment_status = ? LIMIT ? OFFSET ?";
$stmt = $bdd->prepare($query);
$stmt->bind_param("sii", $commentsStatus, $perPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Affiche les commentaires
while ($row = $result->fetch_assoc()) {
    // Affiche chaque commentaire dans votre HTML
    echo '<div class="comment-box">';
    echo '<p class="comment-name">' . $row['firstname'] .' '. $row['lastname'] . '</p>';
    echo '<p class="comment-date"> le : ' . $row['comment_date'] . '</p>';
    echo '<p class="comment-text">' . $row['comment_text'] . '</p>';
   
    echo '</div>';
}

// Liens de pagination (page précédente et page suivante)
$previousPage = $currentPageShow - 1;
$nextPage = $currentPageShow + 1;

echo '<div class="pagination">';
if ($currentPageShow > 1) {
    echo '<a href="showComments.php?commentsStatus=' . $commentsStatus . '&page=' . $previousPage . '">Page précédente</a>';
}
echo '<p>' . $currentPageShow . '</p>';
if (mysqli_num_rows($result) == $perPage) {
    echo '<a href="showComments.php?commentsStatus=' . $commentsStatus . '&page=' . $nextPage . '">Page suivante</a>';
}
echo '</div>';
?>
