<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once ("./phpComponents/head.php");?>
    <title>Titre de la page</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img class="logo" src="./logo_garage.png" alt="logo entreprise" srcset=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?php if ($currentPage == 'dashboard') echo 'active'; ?>" aria-current="page" href="./dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($currentPage == 'adminComments') echo 'active'; ?>" href="./adminComments.php">Commentaires</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($currentPage == 'adminMessages') echo 'active'; ?>" href="./adminMessages.php">Messages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($currentPage == 'adminCars') echo 'active'; ?>" href="./adminCars.php">Véhicules</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
