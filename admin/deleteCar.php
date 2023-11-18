<?php
session_start();
require_once("../backend/bdd.php");

if ($_SESSION['validateToken'] != 1) {
    header('Location: logout.php');
    exit();
}

require_once('../backend/bdd.php');

if (isset($_POST['elementId']) ) {
    $carId = $_POST['elementId'];

    $imageQuery = "SELECT marks.mark_name, cars.car_picture FROM cars 
                    LEFT JOIN marks ON cars.car_mark_id = marks.mark_id
                    WHERE cars.car_id = ?";
    $stmtImage = mysqli_prepare($bdd, $imageQuery);
    mysqli_stmt_bind_param($stmtImage, "i", $carId);
    mysqli_stmt_execute($stmtImage);
    mysqli_stmt_store_result($stmtImage);

    if (mysqli_stmt_num_rows($stmtImage) > 0) {
        mysqli_stmt_bind_result($stmtImage, $markName, $carPicture);
        mysqli_stmt_fetch($stmtImage);

        $imagePath = '../backend/img/' . $markName . '/' . $carPicture;

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    mysqli_stmt_close($stmtImage);

    $deleteCarQuery = "DELETE FROM cars WHERE car_id = ?";
    $stmtCar = mysqli_prepare($bdd, $deleteCarQuery);
    mysqli_stmt_bind_param($stmtCar, "i", $carId);

    if (mysqli_stmt_execute($stmtCar)) {
        
        
        include_once("./phpFunctions/insertLog.php");
        insertLog("suppression du véhicule d'ID : " . $carId, $bdd);
       
    } else {
        $_SESSION['info'] = "Une erreur est survenue lors de la suppression du véhicule : " . mysqli_error($bdd);
        $_SESSION['info-type'] = "error";
    }

    mysqli_stmt_close($stmtCar);
}
$_SESSION['info'] = "Le véhicule a bien été supprimé.";
$_SESSION['info-type'] = "success";
header("Location:./adminCars.php");
exit();

?>
