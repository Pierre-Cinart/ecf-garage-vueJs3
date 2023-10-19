<?php
// Inclure le fichier autoload.php de Composer
require '../vendor/autoload.php';

// Importer la classe Dotenv pour gérer les variables d'environnement
use Dotenv\Dotenv;

// Créer une instance de Dotenv en mode immuable et charger les variables d'environnement à partir du fichier .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Récupérer les identifiants de connexion à la base de données depuis les variables d'environnement
$host_name = $_ENV['DB_HOST'];
$database = $_ENV['DB_DATABASE'];
$user_name = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];

// Établir une connexion à la base de données
$bdd = new mysqli($host_name, $user_name, $password, $database);

// Vérifier si la connexion a échoué
if ($bdd->connect_error) {
  // En cas d'échec de connexion, afficher un message d'erreur et arrêter le script
  die('<p>La connexion au serveur MySQL a échoué: ' . $bdd->connect_error . '</p>');
}
// ...
// Vous pouvez maintenant effectuer des opérations sur la base de données en utilisant l'objet $bdd
// ...
?>
