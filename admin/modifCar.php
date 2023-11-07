<?php
session_start();
$currentPage = 'adminCars';

if (!isset($_SESSION["log_in"])) {
    header('Location: logout.php');
    exit();
}

require_once('../backend/bdd.php');

// Initialisation des variables
$carId = $marque = $modele = $km = $couleur = $price = $infos = '';
$carPicture = ''; // Nouvelle variable pour le nom de l'image

// Vérifie si un ID de véhicule a été transmis via POST
if (isset($_POST['carId']) ) {
    $carId = $_POST['carId'];

    // Requête SQL pour récupérer les informations du véhicule, y compris la marque et la couleur
    $query = "SELECT c.*, m.mark_name AS car_mark, cl.color_name AS car_color FROM cars c
              LEFT JOIN marks m ON c.car_mark_id = m.mark_id
              LEFT JOIN colors cl ON c.car_color_id = cl.color_id
              WHERE c.car_id = ?";

    $stmt = mysqli_prepare($bdd, $query);
    mysqli_stmt_bind_param($stmt, "i", $carId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die('Erreur dans la requête SQL : ' . mysqli_error($bdd));
    }

    // Récupère les informations du véhicule, de la marque et de la couleur
    $vehicleInfo = mysqli_fetch_assoc($result);
    $mark = $vehicleInfo['car_mark'];
    $model = $vehicleInfo['car_model'];
    $km = $vehicleInfo['car_km'];
    $color = $vehicleInfo['car_color'];
    $price = $vehicleInfo['car_price'];
    $infos = $vehicleInfo['car_info'];
    $picture = $vehicleInfo['car_picture'];

    // Libérer les ressources de la requête préparée
    mysqli_stmt_close($stmt);
    // Récupérer la liste des marques depuis la base de données
    $marks = array();
    $query = "SELECT mark_name FROM marks";
    $result = mysqli_query($bdd, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $marks[] = $row['mark_name'];
        }
    }
    sort($marks);
}

// Récupérer la liste des couleurs depuis la base de données
$colors = array();
$query = "SELECT color_name FROM colors";
$result = mysqli_query($bdd, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $colors[] = $row['color_name'];
    }
    sort($colors);
}

if (isset($_POST['modif'])) {
   
    $mark = htmlspecialchars($_POST['car_mark']);
    $model = htmlspecialchars($_POST['car_model']);
    $km = intval($_POST['car_km']);
    $color = htmlspecialchars($_POST['car_color']);
    $price = htmlspecialchars($_POST['car_price']);
    $infos = htmlspecialchars($_POST['car_info']);

    // Gérer l'upload d'une nouvelle image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Chemin du dossier pour les images
        $imageDirectory = '../backend/img/' . $mark . '/';
        if (!file_exists($imageDirectory)) {
            mkdir($imageDirectory, 0777, true);
        }

        // Nom du fichier de l'image
        $imageFilename = $model;

        // Obtenir l'extension du fichier uploadé
        $imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        // Générer un nom de fichier unique en ajoutant un numéro si nécessaire
        $count = 1;
        while (file_exists($imageDirectory . $imageFilename . '.' . $imageExtension)) {
            $imageFilename = $model . "($count)";
            $count++;
        }

        // Composer le nom de fichier final
        $imageFilename = $imageFilename . '.' . $imageExtension;

        // Déplacer le fichier uploadé dans le dossier
        $imagePath = $imageDirectory . $imageFilename;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        $carPicture = $imageFilename;
    } else {
        // Conserver l'image actuelle si aucun fichier n'a été téléchargé
        $carPicture = $picture;
    }

    // Obtenez l'ID de la marque à partir de la table des marques
    $markQuery = "SELECT mark_id FROM marks WHERE mark_name = ?";
    $stmtMark = mysqli_prepare($bdd, $markQuery);
    mysqli_stmt_bind_param($stmtMark, "s", $mark);
    mysqli_stmt_execute($stmtMark);
    mysqli_stmt_store_result($stmtMark);
    mysqli_stmt_bind_result($stmtMark, $markId);
    mysqli_stmt_fetch($stmtMark);
    mysqli_stmt_close($stmtMark);

    // Obtenez l'ID de la couleur à partir de la table des couleurs
    $colorQuery = "SELECT color_id FROM colors WHERE color_name = ?";
    $stmtColor = mysqli_prepare($bdd, $colorQuery);
    mysqli_stmt_bind_param($stmtColor, "s", $color);
    mysqli_stmt_execute($stmtColor);
    mysqli_stmt_store_result($stmtColor);
    mysqli_stmt_bind_result($stmtColor, $colorId);
    mysqli_stmt_fetch($stmtColor);
    mysqli_stmt_close($stmtColor);

    // Mettre à jour le véhicule dans la base de données
    $updateQuery = "UPDATE cars SET car_mark_id = ?, car_model = ?, car_km = ?, car_color_id = ?, car_price = ?, car_info = ?, car_picture = ? WHERE car_id = ?";
    $stmt = mysqli_prepare($bdd, $updateQuery);
    mysqli_stmt_bind_param($stmt, "isssdssi", $markId, $model, $km, $colorId, $price, $infos, $carPicture, $carId);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['info'] = "La modification du véhicule a bien été prise en compte.";
        $_SESSION['info-type'] = "success";
        include_once ("./phpFunctions/insertLog.php");
        insertLog("modification du véhicule : ".$mark." ".$model, $bdd);
    } else {
        $_SESSION['info'] = "Une erreur est survenue lors de la modification du véhicule : " . mysqli_error($bdd);
        $_SESSION['info-type'] = "error";
    }
    header('Location: adminCars.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once("./phpComponents/head.php"); ?>
    <title>Modifier un véhicule</title>
</head>
<body>
    <?php include_once("./phpComponents/header.php"); ?>

    <div class="admin-form car-form">
        <h2>Modifier les informations du véhicule</h2>
        <form action="modifCar.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="carId" value="<?php echo $carId; ?>">
            <div class="form-box">
                <label for="mark">Marque :</label>
                <select name="car_mark" id="markSelect">
                    <option value="">Sélectionnez une marque</option>
                    <?php
                    foreach ($marks as $option) {
                        echo '<option value="' . $option . '"';
                        if ($option == $mark) {
                            echo ' selected';
                        }
                        echo '>' . $option . '</option>';
                    }
                    ?>
                    <option value="Autre">Autre</option>
                </select>
                <input type="text" name="newMark" id="newMarkInput" style="display: none;" placeholder="Nouvelle marque">
            </div>

         
            <div class="form-box">
                <label for="model">Modèle :</label>
                <input type="text" name="car_model" id="model" value="<?php echo $model; ?>">
            </div>

           
            <div class ="form-box">
                <label for="km">Kilométrage :</label>
                <input type="text" name="car_km" id="km" value="<?php echo $km; ?>">
            </div>
            <div class="form-box">
                <label for="color">Couleur :</label>
                <select name="car_color" id="colorSelect">
                    <?php
                    foreach ($colors as $option) {
                        echo '<option value="' . $option . '"';
                        if ($option == $color) {
                            echo ' selected';
                        }
                        echo '>' . $option . '</option>';
                    }
                    ?>
                    <option value="Autre">Autre</option>
                </select>
                <input type="text" name="newColor" id="newColorInput" style="display: none;" placeholder="Nouvelle couleur">
            </div>
            <div class="form-box">
                <label for="price">Prix :</label>
                <input type="text" name="car_price" id="price" value="<?php echo $price; ?>">
            </div>
            <div class="form-box">
                <img id="preview-image" src="http://localhost/garage-v-parrot-vue/backend/img/<?php echo $mark . '/' . $picture; ?>" alt="Image actuelle">
            </div>
            <div class="form-box">
                <label for="image">Nouvelle image :</label>
                <input type="file" name="image" id="image" accept=".jpeg, .jpg" onchange="showImage(this);">
            </div>
            <div class="form-box">
                <label for="infos">Info :</label>
                <textarea name="car_info" id="infos" rows="6" cols="32"><?php echo $infos; ?></textarea>
            </div>

            <input type="submit" class="btn-sub" style="margin-left: 80%;" value="Modifier" name="modif">
        </form>
    </div>
    <?php include_once("./phpComponents/script.php"); ?>
    <script>
        function showImage(input) {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageElement = document.getElementById('preview-image');
                    imageElement.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }

            document.getElementById('newMarkInput').style.display = 'none';
            document.getElementById('newColorInput').style.display = 'none';
        }

        document.getElementById('markSelect').addEventListener('change', function() {
            var newMarkInput = document.getElementById('newMarkInput');
            if (this.value === 'Autre') {
                newMarkInput.style.display = 'block';
            } else {
                newMarkInput.style.display = 'none';
            }
        });

        document.getElementById('colorSelect').addEventListener('change', function() {
            var newColorInput = document.getElementById('newColorInput');
            if (this.value === 'Autre') {
                newColorInput.style.display = 'block';
            } else {
                newColorInput.style.display = 'none';
            }
        });
    </script>
</body>
</html>
