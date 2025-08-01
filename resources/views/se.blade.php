<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejemplo Vue.js Seguro</title>

  <!-- Incluir Vue.js desde CDN -->
  <script src="https://unpkg.com/vue@3"></script>
  
  <!-- Incluir CSS desde CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.4/css/bulma.min.css">

  <!-- Content Security Policy (se configura en el servidor) -->
  <!-- Simulación para desarrollo: restricciones de recursos -->
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://unpkg.com; style-src 'self' https://cdnjs.cloudflare.com;">

  <!-- Simulación de X-Frame-Options -->
  <meta http-equiv="X-Frame-Options" content="DENY">

  <!-- X-Content-Type-Options para prevenir interpretaciones erróneas de MIME -->
  <meta http-equiv="X-Content-Type-Options" content="nosniff">

  <!-- Referrer-Policy para restringir la información de referencia -->
  <meta name="referrer" content="strict-origin">

  <!-- Permissions-Policy para controlar permisos del navegador -->
  <meta http-equiv="Permissions-Policy" content="geolocation=(), microphone=(), camera=()">

  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    .app {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div id="app" class="app">
    <h1 class="title is-3">¡Bienvenido a Vue.js con Seguridad!</h1>
    <p class="subtitle is-5">Este es un ejemplo de configuración segura usando encabezados de seguridad.</p>
    <input type="text" v-model="mensaje" placeholder="Escribe algo..." class="input">
    <p class="mt-3">Lo que escribes: {{ mensaje }}</p>
  </div>

  <script>
    const app = Vue.createApp({
      data() {
        return {
          mensaje: ''
        };
      }
    });
    app.mount('#app');
  </script>
</body>
</html>