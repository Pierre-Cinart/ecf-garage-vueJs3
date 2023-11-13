<?php 
// // pour verification de token


if  (isset($_SESSION['password'])) {
        $password = htmlspecialchars($_SESSION["password"]);
        var_dump($password);
        // Assurez-vous de récupérer l'utilisateur de la session correct
        $userId = $_SESSION['user_id'];
        $stmt = $bdd->prepare("SELECT * FROM staff WHERE staff_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user["password_hash"])) {
            // Mot de passe correct   
            // Mettre à jour le timestamp de "token_end" 
            $queryUpdateTokenEnd = $bdd->prepare("UPDATE staff SET token_end = ? WHERE staff_id = ?");
            $newTokenEnd = time() + 1800; // 30 minutes
            $queryUpdateTokenEnd->bind_param("ii", $newTokenEnd, $userId);
            
            
             
        if ($queryUpdateTokenEnd->execute()) {
             // Réinitialisez le compteur d'essais et valider le token
            $_SESSION['validateToken'] = 1;
            $_SESSION['connexion'] = 0;
            
            // Le timestamp du token a été mis à jour avec succès
            // la demande administrateur peut etre effectuée
        } else {
            // Échec de la mise à jour du timestamp du token
            $_SESSION['info'] = 'une erreur est survenue veuillez vous reconnecter';
            $_SESSION['info-type'] = 'error';
            header('Location: logout.php');
            exit();
        }
            
        } else {
            // Mot de passe incorrect, rediriger vers logout.php après 3 essais
            $_SESSION['connexion'] += 1;
            $_SESSION['info'] = 'mot de passe incorrect';
            $_SESSION['info-type'] = 'error';
            if ($_SESSION['connexion'] > 3) {
                $_SESSION['info'] = 'nombre d essais dépassé';
                header('Location: logout.php');
                exit();
            }
        }
    } else {
        // // Rediriger vers logout.php si la demande n'est pas une requête POST valide
        // header('Location: logout.php');
        // exit();
    }
    echo '<div id="password-form">
                    <form method="POST" action="'.$_SESSION['page'].'">
                        <label for="password">Mot de passe :</label>
                        
                        <input type="password" name="password" id="password" placeholder="Mot de passe" required>
                        <input type="submit" name="submit" value="Valider">
                    </form>
            </div>';
?>