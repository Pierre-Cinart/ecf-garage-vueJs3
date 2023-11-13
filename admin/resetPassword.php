demander le mail <br>
exposer la question <br>
demander la réponse secrete<br> (revoir la tentative de connexion en ajoutant un champs à la table staff)
si reponse correcte : envoyer mail de reinitialisation avec un token createToken valable 5minutes enregistré dans la table à token et tokenend ;<br>
affiché le success
et dire que le code n est valable que 5 minutes
click sur le lien comparé le get 

<br>
si isset get token 
demander l email 

si get token == token where email === email afficher un formulaire avec mot de passe et confirmation <br>
de la mme facon que ca  : 
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
unset et destroy la  session 
session info  = mot de passe reinitialisé veuillez vous reconnecter
session info-type = success
et renvoyer sur la page de connexion;