import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import './axios';
import { VueReCaptcha } from 'vue-recaptcha-v3'; // Importez le package VueReCaptcha

const app = createApp(App);

app
  .use(store)
  .use(router);

// Initialisez reCAPTCHA ici avec votre clé de site
app.use(VueReCaptcha, {
  siteKey: '6LfHo7QoAAAAAEC54uF5IlK9iGscA1meFRFsThl2', // Remplacez par votre propre clé
});

app.mount('#app');
