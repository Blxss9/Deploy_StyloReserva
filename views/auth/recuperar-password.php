<section class="min-h-screen flex flex-col lg:flex-row">
    <!-- Imagen de fondo con overlay mejorado -->
    <div class="hidden lg:block lg:w-1/2 relative">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/build/img/barberia3.jpg');">
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
            <h2 class="text-3xl lg:text-4xl font-bold text-center mb-2 bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                Recuperar Contraseña
            </h2>
            <p class="text-center text-gray-400 mb-8">
                Ingresa tu nueva contraseña a continuación
            </p>

            <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

            <?php if(isset($passwordActualizado) && $passwordActualizado): ?>
                <!-- Modal de éxito -->
                <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-gray-800 p-8 rounded-lg shadow-xl max-w-md w-full mx-4">
                        <div class="text-center">
                            <!-- Icono de éxito -->
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-xl font-medium text-white mb-4">¡Contraseña Actualizada!</h3>
                            <p class="text-gray-300 mb-6">Tu contraseña ha sido actualizada correctamente. Serás redirigido al login en <span id="countdown">3</span> segundos.</p>
                            
                            <button id="okButton" class="w-full bg-green-600 text-white rounded-lg px-4 py-2 hover:bg-green-700 transition-colors">
                                OK
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let countdown = 3;
                        const countdownDisplay = document.getElementById('countdown');
                        const modal = document.getElementById('successModal');
                        const okButton = document.getElementById('okButton');

                        // Manejar clic en el botón OK
                        okButton.addEventListener('click', function() {
                            window.location.href = '/login';
                        });

                        // Iniciar cuenta regresiva
                        const timer = setInterval(function() {
                            countdown--;
                            countdownDisplay.textContent = countdown;
                            
                            if (countdown <= 0) {
                                clearInterval(timer);
                                window.location.href = '/login';
                            }
                        }, 1000);
                    });
                </script>
            <?php endif; ?>

            <?php if(!$error && !$passwordActualizado): ?>
                <!-- Formulario modernizado -->
                <form id="formRecuperarPassword" method="POST" class="space-y-6">
                    <!-- Campo de Password -->
                    <div class="form-group relative">
                        <label for="password" class="block text-sm text-gray-400 mb-1">Nueva Contraseña</label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Tu nueva contraseña"
                                   class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-white pr-10">
                            <!-- Opcional: Icono de ojo para mostrar/ocultar contraseña -->
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        
                    </div>

                    <!-- Botón de Submit -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Guardar Nueva Contraseña</span>
                    </button>
                </form>
            <?php endif; ?>

            <!-- Enlaces adicionales -->
            <div class="mt-8 flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 text-sm text-gray-400">
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
