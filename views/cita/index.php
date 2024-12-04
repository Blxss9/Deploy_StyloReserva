<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-0 text-white animate-fade-in" value="<?php echo $nombre; ?>">
            ¡Bienvenido <?php echo $nombre; ?>!
        </h1>
        <h2 class="text-2xl font-medium text-center text-white mb-12 mt-2">
            Sigue los pasos para agendar tu cita
        </h2>
        
        <!-- Botón Volver -->
        <a href="/"
            class="absolute top-4 left-4 bg-gradient-to-r from-blue-500 to-blue-600 
                   text-white text-sm md:text-base font-semibold py-1.5 md:py-2 px-3 md:px-4 rounded-lg 
                   shadow-md flex items-center gap-1.5 md:gap-2">
            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="hidden sm:inline">Volver</span>
            <span class="sm:hidden">←</span>
        </a>

        <!-- Botón Cerrar Sesión -->
        <a href="/logout"
            class="absolute top-4 right-4 bg-gradient-to-r from-red-500 to-red-600 
                   text-white text-sm md:text-base font-semibold py-1.5 md:py-2 px-3 md:px-4 rounded-lg 
                   shadow-md flex items-center gap-1.5 md:gap-2">
            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="hidden sm:inline">Cerrar Sesión</span>
            <span class="sm:hidden">Salir</span>
        </a>


        <div id="app">
            <!-- Campos ocultos para ID y nombre del cliente -->
            <input type="hidden" id="id" value="<?php echo $_SESSION['id'] ?? ''; ?>">
            <input type="hidden" id="nombre" value="<?php echo $_SESSION['nombre'] ?? ''; ?>">
            
            <!-- Progress Bar -->
            <div class="mb-12">
                <div class="flex justify-between relative">
                    <!-- Línea de conexión entre pasos -->
                    <div class="absolute top-6 left-0 right-0 h-1 bg-gray-200">
                        <div id="progress" class="h-full bg-blue-600 transition-all duration-500 rounded-full" 
                             style="width: 0%"></div>
                    </div>
                    
                    <!-- Paso 1 -->
                    <div class="w-1/4 text-center relative z-10">
                        <button data-paso="1" 
                                class="step-button w-12 h-12 rounded-full bg-blue-600 text-white font-bold mb-3 mx-auto 
                                       transform hover:scale-105 transition-all duration-300 shadow-md 
                                       flex items-center justify-center">
                            <span>1</span>
                        </button>
                        <span class="text-sm font-medium text-white">Servicios</span>
                    </div>

                    <!-- Paso 2 -->
                    <div class="w-1/4 text-center relative z-10">
                        <button data-paso="2" 
                                class="step-button w-12 h-12 rounded-full bg-gray-200 text-gray-400 font-bold mb-3 mx-auto 
                                       transform hover:scale-105 transition-all duration-300 shadow-md 
                                       flex items-center justify-center">
                            <span>2</span>
                        </button>
                        <span class="text-sm font-medium text-white">Fecha y Hora</span>
                    </div>

                    <!-- Paso 3 -->
                    <div class="w-1/4 text-center relative z-10">
                        <button data-paso="3" 
                                class="step-button w-12 h-12 rounded-full bg-gray-200 text-gray-400 font-bold mb-3 mx-auto 
                                       transform hover:scale-105 transition-all duration-300 shadow-md 
                                       flex items-center justify-center">
                            <span>3</span>
                        </button>
                        <span class="text-sm font-medium text-white">Resumen</span>
                    </div>

                    <!-- Paso 4 -->
                    <div class="w-1/4 text-center relative z-10">
                        <button data-paso="4" 
                                class="step-button w-12 h-12 rounded-full bg-gray-200 text-gray-400 font-bold mb-3 mx-auto 
                                       transform hover:scale-105 transition-all duration-300 shadow-md 
                                       flex items-center justify-center">
                            <span>4</span>
                        </button>
                        <span class="text-sm font-medium text-white">Pago</span>
                    </div>
                </div>
            </div>

            <!-- Secciones -->
            <!-- Seccion 1 Servicios     -->
            <div id="paso-1" class="seccion bg-white rounded-2xl shadow-lg p-8 transform transition-all duration-300 hover:shadow-xl border border-gray-100">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800 flex items-center">
                    <span class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </span>
                    Servicios Disponibles
                </h2>
                <p class="text-start text-gray-600 mb-8">Selecciona los servicios que deseas agendar</p>
                <div id="servicios" class="grid grid-cols-1 md:grid-cols-2 gap-6"></div>
            </div>

            <!-- Seccion 2 Fecha y Hora -->
            <div id="paso-2" class="seccion hidden bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800 flex items-center">
                    <span class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    Fecha y Hora
                </h2>
                <p class="text-start text-gray-600 mb-6">Selecciona la fecha y hora de tu cita</p>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="fecha">Fecha:</label>
                    <input type="date" id="fecha" class="w-full p-2 border rounded">
                </div>

                <div id="horas-disponibles" class="hidden">
                    <h3 class="text-xl font-semibold mb-4">Horas Disponibles:</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Mañana</h4>
                            <div id="horas-mañana" class="grid grid-cols-3 gap-2"></div>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Tarde</h4>
                            <div id="horas-tarde" class="grid grid-cols-3 gap-2"></div>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Noche</h4>
                            <div id="horas-noche" class="grid grid-cols-3 gap-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seccion 3 Resumen -->
            <div id="paso-3" class="seccion hidden bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800 flex items-center">
                    <span class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </span>
                    Resumen
                </h2>
                <p class="text-start text-gray-600 mb-6">Verifica que la información sea correcta</p>
                <div id="resumen-cita" class="space-y-4"></div>
            </div>

            <!-- Seccion 4 Pago -->
            <div id="paso-4" class="seccion hidden bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800 flex items-center">
                    <span class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    Pago
                </h2>
                <p class="text-start text-gray-600 mb-6">Selecciona tu método de pago preferido</p>
                
                <!-- Acordeón de opciones de pago -->
                <div class="space-y-4">
                    <!-- Opción 1: Pago en establecimiento -->
                    <div class="border rounded-lg">
                        <button class="w-full px-4 py-3 text-left font-medium flex justify-between items-center focus:outline-none" 
                                onclick="toggleAccordion('pago-establecimiento')">
                            <span>Pago en establecimiento</span>
                            <svg class="w-5 h-5 transform transition-transform" id="arrow-establecimiento" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="pago-establecimiento" class="hidden px-4 pb-4">
                            <p class="text-gray-600 mb-4">Realiza el pago directamente en nuestro local al momento de tu cita.</p>
                            <button id="btn-agendar" 
                                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                                Agendar Cita
                            </button>
                        </div>
                    </div>

                    <!-- Opción 2: Pago con PayPal -->
                    <div class="border rounded-lg">
                        <button class="w-full px-4 py-3 text-left font-medium flex justify-between items-center focus:outline-none"
                                onclick="toggleAccordion('pago-paypal')">
                            <span>Pago anticipado con PayPal</span>
                            <svg class="w-5 h-5 transform transition-transform" id="arrow-paypal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="pago-paypal" class="hidden px-4 pb-4">
                            <p class="text-gray-600 mb-4">Realiza el pago ahora y asegura tu cita.</p>
                            <div id="paypal-button-container" class="min-h-[150px]"></div>
                            <p id="result-message" class="mt-4 text-center"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de navegación -->
            <div class="fixed bottom-0 left-0 right-0 bg-white bg-opacity-95 shadow-lg border-t border-gray-100 p-4">
                <div class="max-w-4xl mx-auto flex justify-between items-center gap-4">
                    <button id="anterior" 
                            class="flex-1 md:flex-none px-8 py-4 bg-gray-600 text-white rounded-lg hover:bg-gray-700 
                                   transition-all duration-300 transform hover:-translate-x-1 
                                   disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:transform-none 
                                   shadow-md hover:shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Anterior
                    </button>
                    
                    <button id="siguiente" 
                            class="flex-1 md:flex-none px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 
                                   text-white rounded-lg hover:from-blue-600 hover:to-blue-700 
                                   transition-all duration-300 transform hover:translate-x-1 
                                   disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:transform-none 
                                   shadow-md hover:shadow-lg flex items-center justify-center">
                        <span>Siguiente</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Añadir padding al final del contenido principal para evitar que los botones fijos solapen contenido -->
<div class="pb-24"></div>

