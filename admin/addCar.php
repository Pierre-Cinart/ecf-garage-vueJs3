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

if (isset($_POST['car_id'])) {
    $carId = $_POST['car_id'];

    // Récupérer les données du véhicule depuis la base de données
    $query = "SELECT c.car_id, m.mark_name, c.car_model, c.car_km, co.color_name, c.car_price, c.car_info, c.car_picture
              FROM cars c
              JOIN marks m ON c.car_mark_id = m.mark_id
              JOIN colors co ON c.car_color_id = co.color_id
              WHERE c.car_id = ?";
    $stmt = mysqli_prepare($bdd, $query);
    mysqli_stmt_bind_param($stmt, "i", $carId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $carId, $marque, $modele, $km, $couleur, $price, $infos, $carPicture);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

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
    sort($colors);
}

if (isset($_POST['create'])) {
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
    <title>Ajouter un véhicule</title>
</head>
<body>
    <?php include_once("./phpComponents/header.php"); ?>
    <div class="admin-form car-form">
        <h2>Modifier les informations du véhicule</h2>
        <form action="addCar.php" method="post" enctype="multipart/form-data">
            <div class="form-box">
                <label for="car_mark">Marque :</label>
                <select name="car_mark" id="car_mark">
                    <option value="">Sélectionnez une marque</option>
                    <?php
                    foreach ($marks as $option) {
                        echo '<option value="' . $option . '"';
                        if ($option == $marque) {
                            echo ' selected';
                        }
                        echo '>' . $option . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-box">
                <label for="car_model">Modèle :</label>
                <input type="text" name="car_model" id="car_model" value="<?php echo $modele; ?>">
            </div>
            <div class="form-box">
                <label for="car_km">Kilométrage :</label>
                <input type="text" name="car_km" id="car_km" value="<?php echo $km; ?>">
            </div>
            <div class="form-box">
                <label for="car_color">Couleur :</label>
                <select name="car_color" id="car_color">
                    <?php
                    foreach ($colors as $option) {
                        echo '<option value="' . $option . '"';
                        if ($option == $couleur) {
                            echo ' selected';
                        }
                        echo '>' . $option . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-box">
                <label for="car_price">Prix :</label>
                <input type="text" name="car_price" id="car_price" value="<?php echo $price; ?>">
            </div>
            <div class="form-box">
                <label for="image">Nouvelle image :</label>
                <input type="file" name="image" id="image" accept=".jpeg, .jpg" onchange="showImage(this);">
            </div>
            <div class="form-box">
                <img id="preview-image" src="../backend/img/<?php echo $marque . '/' . $carPicture; ?>" alt="Image actuelle">
            </div>
            <div class="form-box">
                <label for="car_info">Info :</label>
                <textarea name="car_info" id="car_info" rows="6" cols="32"><?php echo $infos; ?></textarea>
            </div>
            <input type="submit" class="btn-sub" style="margin-left: 80%;" value="Modifier" name="create">
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
        }
    </script>
</body>
</html>
