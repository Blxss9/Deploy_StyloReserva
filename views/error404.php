<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Página no encontrada</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900">

  <div class="min-h-screen flex flex-col md:flex-row justify-center">
    <!-- Left content -->
    <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center items-center">
      <!-- Logo -->
      
      <!-- Error content -->
      <div class="space-y-6 max-w-lg text-center md:text-left">
        <h2 class="text-amber-500 text-2xl font-medium">Error 404</h2>
        <h1 class="text-6xl font-bold text-white">Página no encontrada ⚠️</h1>
        <p class="text-xl text-white font-medium">
          Lo sentimos, no pudimos encontrar la página que estás buscando.
        </p>
        <a href="/" class="inline-flex items-center bg-amber-500 text-white hover:bg-amber-600 font-bold py-2 px-4 rounded-full">
          ← Regresar al inicio
        </a>
      </div>
    </div>

    <!-- Right image -->
    <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('/build/img/barberia1.jpg');">
      <div class="h-full bg-black bg-opacity-10"></div>
    </div>
  </div>

</body>
</html>



