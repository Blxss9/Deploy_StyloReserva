<!-- Vista de Crear Cuenta -->
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
            <h2 class="text-3xl lg:text-4xl font-bold text-center mb-2 bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">Crea tu cuenta</h2>
            <p class="text-center text-gray-400 mb-5">Únete a nuestra comunidad</p>

            <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

            <!-- Formulario modernizado -->
            <form id="formCrearCuenta" action="/crear-cuenta" method="POST" class="space-y-4">
                <!-- Campos del formulario actualizados -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="nombre" class="block text-sm text-gray-400 mb-1">Nombre</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo s($usuario->nombre); ?>" 
                               class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>

                    <div class="form-group">
                        <label for="apellido" class="block text-sm text-gray-400 mb-1">Apellido</label>
                        <input type="text" id="apellido" name="apellido" value="<?php echo s($usuario->apellido); ?>" 
                               class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                </div>

                <!-- Campo de Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-sm lg:text-base">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Tu E-mail" value="<?php echo s($usuario->email); ?>" class="w-full px-4 py-2 lg:py-3 rounded-md border border-gray-300 text-gray-900 focus:ring-2 focus:ring-blue-500" >
                </div>

                 <!-- Campo de Teléfono -->
                <div class="mb-4">
                    <label for="telefono" class="block text-gray-300 text-sm lg:text-base">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" placeholder="Tu Teléfono" value="<?php echo s($usuario->telefono); ?>" class="w-full px-4 py-2 lg:py-3 rounded-md border border-gray-300 text-gray-900 focus:ring-2 focus:ring-blue-500">
                    <p id="error-telefono" class="text-red-500 text-sm hidden">El teléfono debe contener exactamente 9 dígitos</p>
                </div>

                <!-- Campo de Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-300 text-sm lg:text-base">Password</label>
                    <input type="password" id="password" name="password" placeholder="Tu Password" value="<?php echo s($usuario->password); ?>" class="w-full px-4 py-2 lg:py-3 rounded-md border border-gray-300 text-gray-900 focus:ring-2 focus:ring-blue-500">
                    <p id="error-password" class="text-red-500 text-sm hidden">El password debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial</p>
                </div>

                <!-- Botón de Crear Cuenta -->
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-[1.02]">
                    Crear Cuenta
                </button>
            </form>

            <!-- Botón de Google modernizado -->
            <button type="button" class="w-full mt-4 bg-white/10 backdrop-blur-sm text-white border border-gray-600 py-3 rounded-lg font-medium hover:bg-white/20 transition-all duration-300 flex items-center justify-center space-x-2">
                <img src="/build/img/google.svg" alt="Google" class="w-5 h-5">
                <span>Registrate con Google</span>
            </button>

            <!-- Enlaces mejorados -->
            <div class="flex flex-col sm:flex-row justify-between mt-6 space-y-2 sm:space-y-0 text-sm text-gray-400">
                <a href="/login" class="hover:text-blue-400 transition-colors">¿Ya tienes cuenta? Inicia Sesión</a>
                <a href="/olvide" class="hover:text-blue-400 transition-colors">¿Olvidaste tu contraseña?</a>
            </div>
        </div>
    </div>
</section>

<script>
    function validarFormulario() {
        let valido = true;

        // Validar Teléfono
        const telefono = document.getElementById('telefono').value;
        const errorTelefono = document.getElementById('error-telefono');
        if (!/^\d{9}$/.test(telefono)) {
            errorTelefono.classList.remove('hidden');
            valido = false;
        } else {
            errorTelefono.classList.add('hidden');
        }

        // Validar Password
        const password = document.getElementById('password').value;
        const errorPassword = document.getElementById('error-password');
        if (!/^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*\d).{8,}$/.test(password)) {
            errorPassword.classList.remove('hidden');
            valido = false;
        } else {
            errorPassword.classList.add('hidden');
        }

        return valido;
    }
</script>
