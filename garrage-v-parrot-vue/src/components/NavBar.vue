<template>
  <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-secondary">
      <div class="container-fluid">
        <router-link to="/" class="navbar-brand">
          <img src="@/assets/images/logos/logo_garage.png" alt="logo garage V-parrot">
        </router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link to="/home" class="nav-link active" aria-current="page">Accueil</router-link>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Nos services
              </a>
              <ul class="dropdown-menu bg-secondary">
                <li>
                  <router-link to="/reparations_carroseries" class="dropdown-item">Réparation de carrosseries</router-link>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <router-link to="/reparations_mecaniques" class="dropdown-item">Réparations mécaniques</router-link>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <router-link to="/entretiens_vehicules" class="dropdown-item">Entretiens véhicules</router-link>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <router-link to="/ventes_de_vehicules" class="nav-link" style="font-weight: bold;">Nos véhicules en vente</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/home #a_propos" class="nav-link">À propos</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/home#avis_clients" class="nav-link">Réactions des clients</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/contact" class="nav-link">Contact</router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
export default {
  name: "NavBar",
  data() {
    return {
      isMenuOpen: false,
      isDropdownOpen: false,
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
  },
};
</script>

<style scoped>
header {
  font-size: 18px;
}
header a {
  font-size: 18px !important;
  color: rgb(243, 237, 152) !important;
}
header a:hover {
  font-size: 19px !important;
}
header .nav-item {
  margin: 10px;
  border-radius: 25%;
}
header .dropdown-item:hover, header .nav-item:hover {
  background-color: rgb(206, 48, 48) !important;
  font-weight: bolder;
}
header img {
  width: 80px;
}

.header-nav {
  width: 100%;
  padding: 0;
  margin: 0;
  background-color: red;
}

.navBar-ConnectLink {
  font-size: 12px;
  color: darkblue !important;
  text-decoration: none;
}

.navBar-ConnectLink:hover {
  font: size 12px !important;
  color: blue !important;
}
</style>
