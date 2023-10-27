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
                <li class="nav-item " id="logoutItem">
                    <a class="nav-link " href="logout.php">Déconnexion</a>
                </li>
            </div>
        </nav>
    </header>
    <script>
  
  // Sélectionnez le bouton de menu déroulant
  var menuButton = document.querySelector(".navbar-toggler");
  
  // Sélectionnez l'élément parent du lien de déconnexion (nav-item)
  var logoutNavItem = document.querySelector("#logoutItem");
  
  // Vérifiez si le nom de la page actuelle est "index.php"
  var currentPage = window.location.pathname.split("/").pop();
  if (currentPage === "index.php") {
      // Si la page est "index.php", ajoutez la classe "disabled" à l'élément enfant "nav-link"
      var logoutLink = logoutNavItem.querySelector(".nav-link");
      logoutLink.classList.add("disabled");
  }
  
  // Créez une fonction pour gérer la visibilité de "Déconnexion"
  function toggleLogoutVisibility() {
      if (menuButton.getAttribute("aria-expanded") === "true") {
          // Le menu est ouvert, affichez l'élément "Déconnexion"
          logoutNavItem.style.display = "block";
      } else {
          // Le menu est fermé, masquez l'élément "Déconnexion"
          logoutNavItem.style.display = "none";
      }
  }
  
  // Appelez la fonction au chargement de la page
  toggleLogoutVisibility();
  
  // Ajoutez un gestionnaire d'événements au bouton de menu déroulant
  menuButton.addEventListener("click", toggleLogoutVisibility);
  
  // Ajoutez un gestionnaire d'événements pour détecter le redimensionnement de la fenêtre
  window.addEventListener("resize", toggleLogoutVisibility);
  
  
  </script>
