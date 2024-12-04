<!-- Vista de Login -->
<section class="min-h-screen flex flex-col lg:flex-row">
    <!-- Imagen de fondo con overlay mejorado -->
    <div class="hidden lg:block lg:w-1/2 relative">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/build/img/barberia2.jpg');">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/30"></div>
        </div>
    </div>

    <!-- Formulario con diseño mejorado -->
    <div class="flex-1 lg:w-1/2 bg-gradient-to-b from-gray-900 to-gray-800 text-white p-6 lg:p-12 relative">
        <!-- Botón Home modernizado -->
        <div class="absolute top-4 right-4 z-10">
            <a href="/" class="group flex items-center space-x-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full transition-all hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:-translate-y-0.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                <span class="text-sm">Inicio</span>
            </a>
        </div>

        <!-- Contenedor principal con altura fija -->
        <div class="max-w-md mx-auto h-full flex flex-col justify-center">
            <div class="space-y-6">
                <div class="text-center">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-2 bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                        Iniciar Sesión
                    </h2>
                    <p class="text-gray-400">Bienvenido de nuevo</p>
                </div>

                <!-- Alertas -->
                <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

                <!-- Formulario modernizado -->
                <form id="formLogin" action="/login<?php echo isset($redirect) ? '?redirect=' . $redirect : ''; ?>" method="POST" class="space-y-6">
                    <!-- Campo de Email -->
                    <div class="form-group">
                        <label for="email" class="block text-sm text-gray-400 mb-1">Correo Electrónico</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               placeholder="correo@ejemplo.com"
                               class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-white">
                    </div>

                    <!-- Campo de Password -->
                    <div class="form-group">
                        <label for="password" class="block text-sm text-gray-400 mb-1">Contraseña</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               placeholder="Tu contraseña"
                               class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-white">
                    </div>

                    <!-- Olvidé mi contraseña -->
                    <div class="flex justify-end">
                        <a href="/olvide" class="text-sm text-gray-400 hover:text-blue-400 transition-colors">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <!-- Botón de Login -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-[1.02]">
                        Iniciar Sesión
                    </button>
                </form>

                <!-- Botón de Google -->
                <button type="button" 
                        class="w-full bg-white/10 backdrop-blur-sm text-white border border-gray-600 py-3 rounded-lg font-medium hover:bg-white/20 transition-all duration-300 flex items-center justify-center space-x-2">
                    <img src="/build/img/google.svg" alt="Google" class="w-5 h-5">
                    <span>Continuar con Google</span>
                </button>

                <!-- Enlaces adicionales -->
                <div class="text-center">
                    <a href="/crear-cuenta" class="text-sm text-gray-400 hover:text-blue-400 transition-colors">
                        ¿No tienes una cuenta? <span class="font-medium">Regístrate</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


