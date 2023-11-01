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

// Création d'un tableau pour stocker les commentaires
$commentBoxes = [];

// Remplissage du tableau avec les commentaires
while ($row = $result->fetch_assoc()) {
    $commentBox = [
        'name' => $row['firstname'] . ' ' . $row['lastname'],
        'date' => 'le : ' . $row['comment_date'],
        'text' => $row['comment_text'],
        'commentId' => $row['comment_id']
    ];

    $commentBoxes[] = $commentBox;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once("./phpComponents/head.php"); ?>
    <title>Gestion des commentaires</title>
</head>
<body>
    <?php include_once("./phpComponents/header.php"); ?>
    <div class="connect-info">
        <div class="btn-connect"></div>
        <p>Connecté en tant que <?php echo $_SESSION["user"]; ?></p>
    </div>

    <div class="comments">
    <?php foreach ($commentBoxes as $comment) : ?>
    <div class="comment-box">
        <div>
            <p class="comment-name"><?= $comment['name'] ?></p>
            <p class="comment-date"><?= $comment['date'] ?></p>
            <p class="comment-text"><?= $comment['text'] ?></p>
        </div>

        <div class="comment-ico">
            <?php if ($commentsStatus == "wait") : ?>
                <form action="./phpFunctions/modifComment.php" method="post">
                    <input type="hidden" name="commentId" value="<?= $comment['commentId'] ?>">
                    <input type="hidden" name="action" value="validate">
                    <button type="submit" class="icon-button bg-green"><i class="fas fa-check-circle"></i></button>
                </form>
            <?php endif; ?>

            <form action="./phpFunctions/modifComment.php" method="post">
                <input type="hidden" name="commentId" value="<?= $comment['commentId'] ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="icon-button bg-red"><i class="fas fa-trash-alt"></i></button>
            </form>
        </div>
    </div>
    <div class="sep"></div>
<?php endforeach; ?>


    </div>

    <div class="pagination">
        <?php
        if ($commentsStatus == "ok") {
            $linkStatus = "ok=1";
        } elseif ($commentsStatus == "wait") {
            $linkStatus = "wait=1";
        }
        $previousPage = $currentPageShow - 1;
        $nextPage = $currentPageShow + 1;
        $hasPreviousPage = ($currentPageShow > 1);
        $hasNextPage = ($currentPageShow < $totalPages);

        if ($hasPreviousPage) {
            echo '<a href="adminComments.php?' . $linkStatus . '&page=' . $previousPage . '">Page précédente</a>';
        }
        echo '<p>' . $currentPageShow . '</p>';
        if ($hasNextPage) {
            echo '<a href="adminComments.php?' . $linkStatus . '&page=' . $nextPage . '">Page suivante</a>';
        }
        ?>
    </div>
</body>
</html>
