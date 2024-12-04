<section class="min-h-screen flex flex-col lg:flex-row">
    <!-- Imagen de fondo con overlay mejorado -->
    <div class="hidden lg:block lg:w-1/2 relative">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/build/img/barberia2.jpg');">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/30"></div>
        </div>
    </div>

    <!-- Formulario con diseño mejorado -->
    <div class="flex-1 lg:w-1/2 bg-gradient-to-b from-gray-900 to-gray-800 text-white p-6 lg:p-12">
        <!-- Botón Home modernizado -->
        <div class="absolute top-4 right-4">
            <a href="/" class="group flex items-center space-x-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full transition-all hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:-translate-y-0.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                <span class="text-sm">Inicio</span>
            </a>
        </div>

        <div class="max-w-md mx-auto mt-12 lg:mt-0">
            <!-- Icono -->
            <div class="flex justify-center mb-8">
                <div class="bg-blue-500/10 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl lg:text-4xl font-bold text-center mb-2 bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                ¿Olvidaste tu contraseña?
            </h2>
            <p class="text-center text-gray-400 mb-8">
                No te preocupes, te enviaremos instrucciones para restablecerla
            </p>

            <!-- Alertas -->
            <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

            <!-- Formulario modernizado -->
            <form action="/olvide" method="POST" class="space-y-6">
                <div class="form-group">
                    <label for="email" class="block text-sm text-gray-400 mb-1">Correo Electrónico</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               placeholder="correo@ejemplo.com"
                               class="w-full bg-gray-800/50 border border-gray-700 rounded-lg pl-10 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-white">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Enviar Instrucciones</span>
                </button>
            </form>

            <!-- Enlaces -->
            <div class="flex flex-col sm:flex-row justify-between mt-6 space-y-2 sm:space-y-0 text-sm text-gray-400">
                <a href="/login" class="hover:text-blue-400 transition-colors flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    <span>Volver a Iniciar Sesión</span>
                </a>
                <a href="/crear-cuenta" class="hover:text-blue-400 transition-colors">
                    ¿No tienes cuenta? Regístrate
                </a>
            </div>
        </div>
    </div>
</section>
