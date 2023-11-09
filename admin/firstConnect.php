<?php

session_start();
require_once "./phpFunctions/createToken.php";
require_once "../backend/bdd.php";

// Initialise step 
$step = isset($_POST['step']) ? $_POST['step'] : (isset($_SESSION['step']) ? $_SESSION['step'] : 0);
$userId = $_SESSION['user_id'];

// Variable de confirmation du code
$codeConfirmed = isset($_SESSION['code_confirmed']) ? $_SESSION['code_confirmed'] : false;

// Réinitialiser $_SESSION['step'] si nécessaire
if (!isset($_POST['step'])) {
    $_SESSION['step'] = $step;
}

// Fonction pour générer le code
function generateCode() {
    global $bdd, $userId; // Utiliser la connexion PDO et $userId déjà existants
    $randomCode = rand(10000000, 99999999); // Générer un code aléatoire de 8 chiffres
    $tokenEnd = time() + 120;
    $_SESSION['token'] = $randomCode;
    $_SESSION['token_end'] = $tokenEnd;
    
    // Mettre à jour la base de données avec le nouveau code et le nouveau timestamp
    $updateQuery = "UPDATE staff SET token = ?, token_end = ? WHERE staff_id = ?";
    $stmt = $bdd->prepare($updateQuery);
    $stmt->bind_param("iii", $randomCode, $tokenEnd, $userId);
    $stmt->execute();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once("./phpComponents/head.php"); ?>
    <title>première connexion</title>
</head>
<body>
    <?php 
        include_once('./phpComponents/infos.php');
        
        // Demande de confirmation
        if ($step <= 2) {
            echo "Bienvenue, il semble que ce soit votre première connexion ";
            if ($step == 0) {
                echo "Cliquez sur le bouton pour recevoir le code de confirmation ";
            } else {
                echo "Cliquez sur le bouton pour recevoir un nouveau code de confirmation ";
            }
            echo "<form method='post' action='firstConnect.php'>";
            echo "<input type='hidden' name='step' value='1'>";
            echo "<button type='submit'>envoyer le code</button>";
            echo "</form>";
            if ($step == 1){
                generateCode();
            }
            if ($step == 1 || $step == 2) {
                // Génère et enregistre le code 
                
                echo "<form method='post' action='firstConnect.php'>";
                echo "<input type='text' name='confirm_code'></input>";
                echo "<input type='hidden' name='step' value='3'>";
                echo "<button type='submit'>confirmer le code</button>";
                echo "</form>";
            }
        }

        // Confirmation du code 
        if ($step == 3) {
            // Vérification du code 
            if ($_POST['confirm_code'] == $_SESSION['token']) {
                // Succès
                $_SESSION['code_confirmed'] = true;
                $_SESSION['step'] = 4;
                header("Location: firstConnect.php");
                exit();
            } else {
                // Échec, envoie une erreur 
                $_SESSION['info'] = "Code éroné";
                $_SESSION['info-type'] = "error";
                $_SESSION['step'] = 2;
                header("Location: firstConnect.php");
            }
        }

        // Affichage de la sélection de questions et de l'input de réponse
        if ($step == 4 && $codeConfirmed) {
            // Faire la requête sur la table question pour pouvoir afficher les questions
            $questionsQuery = "SELECT * FROM questions";
            $result = $bdd->query($questionsQuery);

            if (!$result) {
                // Afficher l'erreur si la requête échoue
                echo "Erreur dans la requête SQL : " . $bdd->error;
            } else {
                if ($result->num_rows > 0) {
                    echo '<form method="post" action="firstConnect.php">';
                    echo '<label for="question">Choisissez une question secrète :</label>';
                    echo '<select name="question">';
                    
                    // Afficher les options du menu déroulant avec les questions
                    while ($row = $result->fetch_assoc()) {
                        $questionId = $row["id"];
                        $questionText = $row["question"];
                        echo "<option value='$questionId'>$questionText</option>";
                    }

                    echo '</select>';
                    echo '<br>';
                    echo '<label for="secret"> Entrez votre réponse :</label>';
                    echo '<input type="text" name="secret">';
                    echo '<br>';
                    echo '<label for="secret2"> Confirmez votre réponse :</label>';
                    echo '<input type="text" name="secret2">';
                    echo '<input type="hidden" name="step" value="5">';
                    echo '<button type="submit">enregister</button>';
                    echo '</form>';
                } else {
                    echo "Aucune question n'est disponible.";
                }
            }
        }

        // Enregistrement de la réponse à la question secrète
        if ($step == 5) {
            // Récupérer les valeurs des champs secret et secret2 depuis le formulaire
            $secret = isset($_POST['secret']) ? $_POST['secret'] : '';
            $getSecret = isset($_POST['secret2']) ? $_POST['secret2'] : '';

            // Regex autorisant les lettres accentuées entre 3 et 25 caractères
            $regexSecret = '/^[a-zA-ZÀ-ÖØ-öø-ÿ]{3,25}$/u';

            if (preg_match($regexSecret, $secret) && $secret == $getSecret) {
                // Échapper les données et enregistrer l'ID de la question dans staff.id
                $questionId = isset($_POST['question']) ? $_POST['question'] : 0;
                // Vous devez échapper et valider l'ID de la question selon vos besoins et votre base de données

                // Échapper les données de secret, le hacher et l'enregistrer dans staff.secret
                $hashedSecret = password_hash($secret, PASSWORD_DEFAULT);

                // Enregistrement dans la base de données
                $updateQuestionQuery = "UPDATE staff SET question_id = ?, secret_word = ? WHERE staff_id = ?";
                $stmt = $bdd->prepare($updateQuestionQuery);
                $stmt->bind_param("isi", $questionId, $hashedSecret, $userId);
                $stmt->execute();

                $_SESSION['step'] = 6;
                header('Location: firstConnect.php');
                exit;
            } else {
                // Les conditions ne sont pas remplies, définir les sessions info
                $_SESSION['step'] = 4;
                $_SESSION['info'] = "les 2 réponses doivent être identique ,contenir entre 3 et 25 lettres ,ne ne pas contenir de symbole ni de chiffre.";
                $_SESSION['info-type'] = "error";
                header('Location: firstConnect.php');
                exit;
            }
        }

        // Choix d'un nouveau mot de passe
        if ($step == 6) {
            echo "<h2>Choisissez un nouveau mot de passe</h2>";
            echo "<form method='post' action='firstConnect.php'>";
            echo "<label for='password'>Nouveau mot de passe :</label>";
            echo "<input type='password' name='password' required>";
            echo "<br>";
            echo "<label for='confirm_password'>Confirmez le mot de passe :</label>";
            echo "<input type='password' name='confirm_password' required>";
            echo "<input type='hidden' name='step' value='7'>";
            echo "<button type='submit'>Continuer</button>";
            echo "</form>";
        }
        
        // Enregistrement du nouveau mot de passe haché
        if ($step == 7) {
            // Récupérer les valeurs des champs password et confirm_password depuis le formulaire
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        
            // Regex pour vérifier le mot de passe
            $regexPassword = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[+\\-_!?@#]).{8,}$/';
        
            if (preg_match($regexPassword, $password) && $password == $confirmPassword) {
                // Les conditions sont remplies, continuer le processus
                // Hasher le mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Enregistrement du mot de passe haché dans la base de données
                $updatePasswordQuery = "UPDATE staff SET password_hash = ?, rights = 'n' WHERE staff_id = ?";
                $stmt = $bdd->prepare($updatePasswordQuery);
                $stmt->bind_param("si", $hashedPassword, $userId);
                $stmt->execute();
                
                // Réinitialiser les étapes et rediriger
                $_SESSION = array(); // Unset toutes les sessions
                session_destroy(); // Détruire la session
                header('Location: index.php'); // Rediriger vers la page d'accueil
                exit;
            } else {
                // Les conditions ne sont pas remplies, définir les sessions info
                $_SESSION['step'] = 6;
                $_SESSION['info'] = "Les mots de passe doivent être identiques contenir au moins 8 caractères, une majuscule, une minuscule et un symbole parmi +-_!?@#.";
                $_SESSION['info-type'] = "error";
                header('Location: firstConnect.php');
                exit;
            }
        }

        include_once("./phpComponents/script.php");
    ?>
</body>
</html>
