 // pour afficher le boutton de deconnexion
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
 
 
