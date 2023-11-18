<?php
session_start();
// info de connexion 
require_once("../backend/bdd.php");

// verification du token
if ($_SESSION['validateToken'] != 1) {
    header('Location: logout.php');
    exit();
}

require_once('../backend/bdd.php');

if (isset($_POST['adminId'])) {
    $adminId = $_POST['adminId'];

   
    // Supprimer l admin
    $deleteAdminQuery = "DELETE FROM staff WHERE staff_id = ?";
    $stmtAdmin = mysqli_prepare($bdd, $deleteAdminQuery);
    mysqli_stmt_bind_param($stmtAdmin, "i", $adminId);

    if (mysqli_stmt_execute($stmtAdmin)) {
        $_SESSION['info'] = "L ' administrateur à bien était supprimé.";
        $_SESSION['info-type'] = "success";
        include_once("./phpFunctions/insertLog.php");
        insertLog("suppression de l administrateur d'ID : " . $adminId, $bdd);
    } else {
        $_SESSION['info'] = "Une erreur est survenue lors de la suppression de l administrateur: " . mysqli_error($bdd);
        $_SESSION['info-type'] = "error";
        header("Location:./admin.php");
        exit();
    }

    mysqli_stmt_close($stmtCar);
} else {
    $_SESSION['info'] = "Une erreur est survenue.";
    $_SESSION['info-type'] = "error";
}

header("Location:./adminCars.php");
exit();
?>

