<?php
session_start();
// Info de connexion
require_once("../backend/bdd.php");

// Vérification du token
if ($_SESSION['validateToken'] != 1) {
    header('Location: logout.php');
    exit();
}

if (isset($_POST['adminId'])) {
    $adminId = $_POST['adminId'];

    // Supprimer l'admin
    $deleteAdminQuery = "DELETE FROM staff WHERE staff_id = ?";
    $stmtAdmin = mysqli_prepare($bdd, $deleteAdminQuery);
    mysqli_stmt_bind_param($stmtAdmin, "i", $adminId);

    if (mysqli_stmt_execute($stmtAdmin)) {
        $_SESSION['info'] = "L'administrateur a bien été supprimé.";
        $_SESSION['info-type'] = "success";
        include_once("./phpFunctions/insertLog.php");
        insertLog("suppression de l'administrateur d'ID : " . $adminId, $bdd);
    } else {
        $_SESSION['info'] = "Une erreur est survenue lors de la suppression de l'administrateur : " . mysqli_error($bdd);
        $_SESSION['info-type'] = "error";
        header("Location:./admin.php?show=admins");
        exit();
    }

    mysqli_stmt_close($stmtAdmin);
} else {
    $_SESSION['info'] = "Une erreur est survenue.";
    $_SESSION['info-type'] = "error";
    header("Location:./admin.php?show=admins");
    exit();
}

header("Location:./admin.php?show=admins");
exit();
?>
