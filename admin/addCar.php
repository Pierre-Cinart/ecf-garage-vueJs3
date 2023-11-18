
<?php
session_start();
$currentPage = 'adminCars';

if (!isset($_SESSION["log_in"])) {
    header('Location: logout.php');
    exit();
}

require_once('../backend/bdd.php');

// Initialisation des variables
$mark = $model = $km = $color = $price = $infos = '';
$carPicture = ''; // Nouvelle variable pour le nom de l'image

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

// Récupérer la liste des couleurs depuis la base de données
$colors = array();
$query = "SELECT color_name FROM colors";
$result = mysqli_query($bdd, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $colors[] = $row['color_name'];
    }
}
sort($colors);

if (isset($_POST['add'])) {
      // verification de token
      include_once("./phpFunctions/verifToken.php");
      if ($_SESSION['validateToken'] != 1){
          header('Location: logout.php');
          exit();
      }
    $mark = htmlspecialchars($_POST['car_mark']);
    $model = htmlspecialchars($_POST['car_model']);
    $km = intval($_POST['car_km']);
    $color = htmlspecialchars($_POST['car_color']);
    $price = htmlspecialchars($_POST['car_price']);
    $infos = htmlspecialchars($_POST['car_info']);
    $date = intval($_POST['car_date']);

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
        // Si aucune image n'a été téléchargée, vous pouvez choisir une image par défaut
        $carPicture = 'default.jpg'; // Changez cela selon vos besoins
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

    // Insérer le nouveau véhicule dans la base de données
    $insertQuery = "INSERT INTO cars (car_mark_id, car_model, car_km, car_color_id, car_price, car_info, car_picture, car_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($bdd, $insertQuery);
    mysqli_stmt_bind_param($stmt, "isssdssi", $markId, $model, $km, $colorId, $price, $infos, $carPicture, $date);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['info'] = "Le véhicule a été ajouté avec succès.";
        $_SESSION['info-type'] = "success";
        include_once ("./phpFunctions/insertLog.php");
        insertLog("ajout d'un nouveau véhicule : ".$mark." ".$model, $bdd);
    } else {
        $_SESSION['info'] = "Une erreur est survenue lors de l'ajout du véhicule : " . mysqli_error($bdd);
        $_SESSION['info-type'] = "error";
    }
    header('Location: adminCars.php');
    exit();
}
?>

<!-- Le reste du code HTML reste le même -->


<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once("./phpComponents/head.php"); ?>
    <title>Ajouter un véhicule</title>
</head>
<body>
    <?php include_once("./phpComponents/header.php"); ?>

    <div class="admin-form car-form">
        <h2>Ajouter un véhicule</h2>
        <form action="addCar.php" method="post" enctype="multipart/form-data">
           
            <div class="form-box">
                <label for="mark">Marque :</label>
                <select name="car_mark" id="markSelect" required>
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
                <input type="text" name="car_model" id="model" required>
            </div>

           
            <div class ="form-box">
                <label for="km">Kilométrage :</label>
                <input type="text" name="car_km" id="km" required>
            </div>
            <div class="form-box">
                <label for="color">Couleur :</label>
                <select name="car_color" id="colorSelect">
                <option value="">Sélectionnez une couleur</option>
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
                <input type="text" name="car_price" id="price" required>
            </div>
            <div class="form-box">
                <img id="preview-image" src="" alt="Image actuelle">
            </div>
            <div class="form-box">
                <label for="image">Nouvelle image :</label>
                <input type="file" name="image" id="image" accept=".jpeg, .jpg" onchange="showImage(this); required">
            </div>
            <div class="form-box">
                <label for="car_date">année de construction :</label>
                <input type="text" name="car_date" id="car_date" required>
            </div>
            <div class="form-box">
                <label for="infos">Info :</label>
                <textarea name="car_info" id="infos" rows="6" cols="32" required></textarea>
            </div>

            <input type="submit" class="btn-sub" style="margin-left: 80%;" value="Ajouter" name="add">
        </form>
    </div>
    <?php include_once("./phpComponents/script.php"); ?>
    <script src="./js/addInput.js"></script>
</body>
</html>
