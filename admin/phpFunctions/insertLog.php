<?php
function insertLog($action, $bdd) {
   
    // Préparation de la requête SQL
    $query = "INSERT INTO logs (admin_id, action, log_date) VALUES (?, ?, NOW())";

    // Création d'une instruction préparée
    $stmt = mysqli_prepare($bdd, $query);

    if ($stmt) {
        // Liaison des valeurs aux paramètres de la requête
        mysqli_stmt_bind_param($stmt, "is", $_SESSION['user_id'], $action);

        // Exécution de la requête
        if (mysqli_stmt_execute($stmt)) {
            // La requête a réussi, le log a été inséré
            mysqli_stmt_close($stmt);
            return true;
        } else {
            // La requête a échoué
            mysqli_stmt_close($stmt);
            return false;
        }
    } else {
        // Erreur de préparation de la requête
        return false;
    }
}
?>
