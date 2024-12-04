<section class="h-screen flex items-center justify-center bg-gray-900">
    <div class="bg-gray-800 text-white rounded-lg shadow-lg flex flex-col items-center px-6 py-10 w-full max-w-lg sm:px-10 sm:py-12">
        <!-- Título -->
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-center mb-8">Confirmar Cuenta</h1>
        <!-- Alerta de token  -->
        <?php 
            include_once __DIR__ . "/../templates/alertas.php";
        ?>
        
        <!-- Botón para iniciar sesión -->
        <div class="flex justify-center mt-6">
            <a href="/login" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg text-lg">
                Iniciar Sesión
            </a>
        </div>
        <!-- Enlaces adicionales -->
        <div class="mt-6 text-center text-sm text-gray-300 space-y-2">
            <a href="/login" class="hover:underline hover:text-blue-400 block">¿Ya tienes una cuenta? Inicia Sesión</a>
            <a href="/olvide" class="hover:underline hover:text-blue-400 block">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</section>
