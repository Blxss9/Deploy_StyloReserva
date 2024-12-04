<body class="bg-gray-900">
  
  <!-- Navbar -->
  <nav class="bg-black/40 fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">
        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center">
          <a href="/">
          <img src="/build/img/logo.svg" alt="logo_barberia" class="h-20">
          </a>

          <span class="ml-2 text-white text-xl font-bold">Elite Barbershop</span>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:block">
          <div class="m-2 flex items-center space-x-8 font-bold">
            <a href="/" class="text-white hover:text-amber-500 transition-colors">Inicio</a>
            <a href="#seccionPrecios" class="text-white hover:text-amber-500 transition-colors">Servicios</a>
            <a href="#seccionNosotros" class="text-white hover:text-amber-500 transition-colors">Nosotros</a>
            <a href="#seccionContacto" class="text-white hover:text-amber-500 transition-colors">Contacto</a>
          </div>
        </div>
        
        <!-- Social Icons -->
        <div class="hidden md:flex items-center space-x-8 m-2">
          <a href="https://www.facebook.com/">
            <i class="fa-brands fa-facebook fa-xl text-white hover:text-blue-500"></i>
          </a>
          <a href="https://web.whatsapp.com/">
            <i class="fa-brands fa-whatsapp fa-xl text-white hover:text-green-400" ></i>
          </a>
          <a href="https://www.instagram.com/">
            <i class="fa-brands fa-instagram fa-xl text-white hover:text-pink-600"></i>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->


  <div class="relative min-h-screen">
    <!-- Background Image with Overlay -->
    <div class="fixed inset-0 w-full h-full">
        <img src="/build/img/barberia1.jpg" alt="Fondo barbería" class="absolute inset-0 w-full h-full object-cover object-center" />
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 min-h-screen flex items-center">
      <!-- Botón de volver al inicio -->
    <button id="backToTop" class="fixed bottom-5 right-5 bg-amber-500 text-white p-3 rounded-full shadow-lg hover:bg-amber-600 transition-opacity duration-300 opacity-0 z-50">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- JavaScript para mostrar/ocultar y hacer scroll hacia arriba -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopButton = document.getElementById('backToTop');
            // Mostrar el botón cuando se desplaza hacia abajo
            window.addEventListener('scroll', () => {
                if (window.scrollY > 200) {
                    backToTopButton.classList.remove('opacity-0');
                    backToTopButton.classList.add('opacity-100');
                } else {
                    backToTopButton.classList.remove('opacity-100');
                    backToTopButton.classList.add('opacity-0');
                }
            });

            // Scroll hacia arriba al hacer clic en el botón
            backToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>

      <div class="w-full text-center mt-10 sm:text-left">
      <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 sm:mb-8">
            Estilo y <span class="text-amber-500">Elegancia</span>
        </h1>
        <p class="text-gray-300 text-base mt-8 sm:text-lg mb-8 sm:mb-10">
            El lugar donde tu estilo evoluciona. Con técnicas que unen lo clásico y lo contemporáneo, realizamos tu imagen a otro nivel.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 mt-12 mb-8 sm:mb-12">
          <a href="/login" class="bg-amber-500 text-black px-6 sm:px-8 py-3 rounded-full font-semibold hover:bg-amber-400 transition-colors duration-300 flex items-center justify-center">
            <i class="fa-solid fa-calendar-days mr-2"></i>
            Reservar Cita
          <a/>
          <button id="openModal" class="border-2 border-amber-500 text-white px-6 sm:px-8 py-3 rounded-full font-semibold hover:bg-amber-500/10 transition-colors duration-300 flex items-center justify-center">
            <i class="fa-regular fa-clock mr-2" style="color: #ffffff;"></i>
            Ver Horarios
          </button>
        </div>
        <!-- Modulo emergente horarios -->
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Horarios de Atención</h2>
                <ul class="text-gray-700">
                    <li>Lunes a Viernes: 9:00 AM - 8:00 PM</li>
                    <li>Sábado: Cerrado</li>
                    <li>Domingo: Cerrado</li>
                </ul>
                <button id="closeModal" class="mt-6 bg-amber-500 text-white px-4 py-2 rounded hover:bg-amber-600 transition-colors">Cerrar</button>
            </div>
        </div>


        <!-- JavaScript para controlar el modulo de horarios -->
        <script>
          const modal = document.getElementById('modal');
          const modalContent = document.getElementById('modalContent');
          const openModalBtn = document.getElementById('openModal');
          const closeModalBtn = document.getElementById('closeModal');

          openModalBtn.addEventListener('click', function() {
              modal.classList.remove('hidden');
          });

          closeModalBtn.addEventListener('click', function() {
              modal.classList.add('hidden');
          });

          // Cierra el modal al hacer clic fuera del contenido
          modal.addEventListener('click', function(event) {
              if (event.target === modal) {
                  modal.classList.add('hidden');
              }
          });
                    // Cierra el modal al hacer scroll
          window.addEventListener('scroll', function() {
              if (!modal.classList.contains('hidden')) {
                  modal.classList.add('hidden');
              }
          });
          </script>

        <div class="flex flex-col sm:flex-row items-center mt-16 justify-center sm:justify-start space-y-2 sm:space-y-0 sm:space-x-6">
          <div class="text-white">
            <p class="text-2xl sm:text-3xl font-bold">10+</p>
            <p class="text-xs sm:text-sm text-gray-400">Años de<br>Experiencia</p>
          </div>
          <div class="h-8 sm:h-12 w-px bg-amber-500"></div>
          <div class="text-white">
            <p class="text-2xl sm:text-3xl font-bold">5000+</p>
            <p class="text-xs sm:text-sm text-gray-400">Clientes<br>Satisfechos</p>
          </div>
          <div class="h-8 sm:h-12 w-px bg-amber-500"></div>
          <div class="text-white">
            <p class="text-2xl sm:text-3xl font-bold">4.9</p>
            <p class="text-xs sm:text-sm text-gray-400">Calificación<br>Promedio</p>
          </div>
        </div>
      

        



<!-- Sección Nosotros -->
<section id="seccionNosotros" class="py-24 bg-gradient-to-br from-gray-900 to-black w-full mt-60 rounded-lg shadow-2xl">
    <div class="container mx-auto px-8 sm:px-10 lg:px-16">
        <!-- Título de la sección -->
        <div class="text-center mb-16">
            <h2 class="text-5xl font-bold text-amber-500 mb-4">Sobre Nosotros</h2>
            <p class="text-gray-300 text-xl">Tradición y excelencia en barbería desde 1998</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <!-- Columna de imágenes -->
            <div class="relative w-full h-auto space-y-4 lg:space-y-8">
                <!-- Imagen principal -->
                <div class="relative overflow-hidden rounded-2xl shadow-2xl transform hover:scale-105 transition-transform duration-500">
                    <img src="/build/img/barberia2.jpg" alt="Barbería" class="w-full h-auto object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>
                
                <!-- Grid de estadísticas -->
                <div class="grid grid-cols-3 gap-4 mt-8">
                    <div class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-xl text-center transform hover:scale-105 transition-all duration-300">
                        <span class="text-amber-500 text-3xl font-bold block">25+</span>
                        <span class="text-gray-300 text-sm">Años de<br>Experiencia</span>
                    </div>
                    <div class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-xl text-center transform hover:scale-105 transition-all duration-300">
                        <span class="text-amber-500 text-3xl font-bold block">5000+</span>
                        <span class="text-gray-300 text-sm">Clientes<br>Satisfechos</span>
                    </div>
                    <div class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-xl text-center transform hover:scale-105 transition-all duration-300">
                        <span class="text-amber-500 text-3xl font-bold block">4.9</span>
                        <span class="text-gray-300 text-sm">Calificación<br>Promedio</span>
                    </div>
                </div>
            </div>

            <!-- Columna de texto -->
            <div class="flex flex-col space-y-8">
                <div class="space-y-6">
                    <!-- Misión -->
                    <div class="bg-gray-800/30 backdrop-blur-sm p-6 rounded-xl transform hover:scale-105 transition-all duration-300">
                        <h3 class="text-2xl font-bold text-amber-500 mb-4 flex items-center">
                            <i class="fa-solid fa-bullseye mr-3"></i>
                            Nuestra Misión
                        </h3>
                        <p class="text-gray-300 leading-relaxed">
                            Brindar servicios de barbería excepcionales que no solo mejoren la apariencia de nuestros clientes, sino que también eleven su confianza y bienestar personal.
                        </p>
                    </div>

                    <!-- Visión -->
                    <div class="bg-gray-800/30 backdrop-blur-sm p-6 rounded-xl transform hover:scale-105 transition-all duration-300">
                        <h3 class="text-2xl font-bold text-amber-500 mb-4 flex items-center">
                            <i class="fa-solid fa-eye mr-3"></i>
                            Nuestra Visión
                        </h3>
                        <p class="text-gray-300 leading-relaxed">
                            Ser reconocidos como la barbería líder en innovación y calidad, estableciendo nuevos estándares en el cuidado personal masculino.
                        </p>
                    </div>

                    <!-- Valores -->
                    <div class="bg-gray-800/30 backdrop-blur-sm p-6 rounded-xl transform hover:scale-105 transition-all duration-300">
                        <h3 class="text-2xl font-bold text-amber-500 mb-4 flex items-center">
                            <i class="fa-solid fa-star mr-3"></i>
                            Nuestros Valores
                        </h3>
                        <ul class="text-gray-300 grid grid-cols-2 gap-4">
                            <li class="flex items-center">
                                <i class="fa-solid fa-check text-amber-500 mr-2"></i>
                                Excelencia
                            </li>
                            <li class="flex items-center">
                                <i class="fa-solid fa-check text-amber-500 mr-2"></i>
                                Profesionalismo
                            </li>
                            <li class="flex items-center">
                                <i class="fa-solid fa-check text-amber-500 mr-2"></i>
                                Innovación
                            </li>
                            <li class="flex items-center">
                                <i class="fa-solid fa-check text-amber-500 mr-2"></i>
                                Compromiso
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Botón de acción -->
                <div class="text-center lg:text-left">
                    <a href="/login" 
                       class="inline-flex items-center px-8 py-3 bg-amber-500 text-black rounded-full font-semibold hover:bg-amber-400 transition-colors duration-300 transform hover:scale-105">
                        <i class="fa-solid fa-calendar-check mr-2"></i>
                        Agenda tu Cita
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script para animaciones -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-10');
                }
            });
        }, {
            threshold: 0.1
        });

        // Observar todos los elementos animables
        document.querySelectorAll('#seccionNosotros .transform').forEach(el => {
            el.classList.add('opacity-0', 'translate-y-10', 'transition-all', 'duration-700');
            observer.observe(el);
        });
    });
</script>

<!-- Sección de Precios -->
<section id="seccionPrecios" class="py-24 bg-gradient-to-br from-gray-900 to-black rounded-lg mt-12">
    <div class="container mx-auto px-8 sm:px-10 lg:px-16 text-center">
        <h2 class="text-5xl font-bold text-amber-500 mb-4 opacity-0 transform translate-y-4 transition-all duration-700" data-animate>Nuestros Servicios</h2>
        <p class="text-gray-300 text-xl mb-16 opacity-0 transform translate-y-4 transition-all duration-700 delay-100" data-animate>Descubre nuestros servicios y precios premium diseñados para ti</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Tarjeta de Servicio 1 -->
            <div class="relative group opacity-0 transform translate-y-8 transition-all duration-700 delay-200 hover:-translate-y-2" data-animate>
                <div class="absolute inset-0 bg-amber-500 rounded-lg blur opacity-0 group-hover:opacity-40 transition-all duration-500"></div>
                <div class="relative rounded-lg overflow-hidden backdrop-blur-sm bg-black/40 border border-gray-700 group-hover:border-amber-500 transition-all duration-500 ease-out transform">
                    <div class="p-8">
                        <div class="h-16 w-16 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-shower text-2xl text-amber-500"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-6">Lavado de Cabello</h3>
                        <ul class="space-y-4 mb-8">
                            <li id="precioLavado1" class="flex justify-between text-gray-300">
                                <span>Lavado Básico</span>
                                <span class="font-bold text-amber-500">$10.000</span>
                            </li>
                            <li id="precioLavado2" class="flex justify-between text-gray-300">
                                <span>Lavado y Masaje</span>
                                <span class="font-bold text-amber-500">$15.000</span>
                            </li>
                            <li id="precioLavado3" class="flex justify-between text-gray-300">
                                <span>Hidratante</span>
                                <span class="font-bold text-amber-500">$20.000</span>
                            </li>
                            <li id="precioLavado4" class="flex justify-between text-gray-300">
                                <span>Lavado y Estilo</span>
                                <span class="font-bold text-amber-500">$18.000</span>
                            </li>
                        </ul>
                        <a href="/login" class="inline-flex items-center justify-center w-full px-6 py-3 bg-amber-500 text-black rounded-full font-semibold hover:bg-amber-400 transition-colors group-hover:scale-105 duration-300">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Agendar Cita
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Servicio 2 -->
            <div class="relative group opacity-0 transform translate-y-8 transition-all duration-700 delay-300 hover:-translate-y-2" data-animate>
                <div class="absolute inset-0 bg-amber-500 rounded-lg blur opacity-0 group-hover:opacity-40 transition-all duration-500"></div>
                <div class="relative rounded-lg overflow-hidden backdrop-blur-sm bg-black/40 border border-gray-700 group-hover:border-amber-500 transition-all duration-500 ease-out transform">
                    <div class="absolute top-0 right-0 bg-amber-500 text-black px-4 py-1 rounded-bl-lg font-semibold">
                        Más Popular
                    </div>
                    <div class="p-8">
                        <div class="h-16 w-16 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-cut text-2xl text-amber-500"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-6">Corte de Cabello</h3>
                        <ul class="space-y-4 mb-8">
                            <li id="precioCorte1" class="flex justify-between text-gray-300">
                                <span>Corte Clásico</span>
                                <span class="font-bold text-amber-500">$20.000</span>
                            </li>
                            <li id="precioCorte2" class="flex justify-between text-gray-300">
                                <span>Corte Moderno</span>
                                <span class="font-bold text-amber-500">$25.000</span>
                            </li>
                            <li id="precioCorte3" class="flex justify-between text-gray-300">
                                <span>Corte con Diseño</span>
                                <span class="font-bold text-amber-500">$30.000</span>
                            </li>
                            <li id="precioCorte4" class="flex justify-between text-gray-300">
                                <span>Recorte y Estilo</span>
                                <span class="font-bold text-amber-500">$22.000</span>
                            </li>
                        </ul>
                        <a href="/login" class="inline-flex items-center justify-center w-full px-6 py-3 bg-amber-500 text-black rounded-full font-semibold hover:bg-amber-400 transition-colors group-hover:scale-105 duration-300">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Agendar Cita
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Servicio 3 -->
            <div class="relative group opacity-0 transform translate-y-8 transition-all duration-700 delay-400 hover:-translate-y-2" data-animate>
                <div class="absolute inset-0 bg-amber-500 rounded-lg blur opacity-0 group-hover:opacity-40 transition-all duration-500"></div>
                <div class="relative rounded-lg overflow-hidden backdrop-blur-sm bg-black/40 border border-gray-700 group-hover:border-amber-500 transition-all duration-500 ease-out transform">
                    <div class="p-8">
                        <div class="h-16 w-16 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fa-solid fa-wand-magic-sparkles text-2xl text-amber-500"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-6">Recorte de Barba</h3>
                        <ul class="space-y-4 mb-8">
                            <li id="precioBarba1" class="flex justify-between text-gray-300">
                                <span>Recorte Básico</span>
                                <span class="font-bold text-amber-500">$12.000</span>
                            </li>
                            <li id="precioBarba2" class="flex justify-between text-gray-300">
                                <span>Recorte Full</span>
                                <span class="font-bold text-amber-500">$15.000</span>
                            </li>
                            <li id="precioBarba3" class="flex justify-between text-gray-300">
                                <span>Afeitado Clásico</span>
                                <span class="font-bold text-amber-500">$18.000</span>
                            </li>
                            <li id="precioBarba4" class="flex justify-between text-gray-300">
                                <span>Estilo de Barba</span>
                                <span class="font-bold text-amber-500">$20.000</span>
                            </li>
                        </ul>
                        <a href="/login" class="inline-flex items-center justify-center w-full px-6 py-3 bg-amber-500 text-black rounded-full font-semibold hover:bg-amber-400 transition-colors group-hover:scale-105 duration-300">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Agendar Cita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script para las animaciones -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.remove('opacity-0', 'translate-y-4', 'translate-y-8');
                entry.target.classList.add('opacity-100', 'translate-y-0');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    // Observar todos los elementos con data-animate
    document.querySelectorAll('[data-animate]').forEach(element => {
        observer.observe(element);
    });
});
</script>

<!-- Sección de Testimonios -->
<section id="testimonials" class="py-24 bg-gray-900 text-white mt-12 rounded-lg">
    <div class="container mx-auto px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-amber-500 mb-4">Testimonios</h2>
            <p class="text-gray-400 text-lg">Lo que dicen nuestros clientes sobre nosotros</p>
        </div>
        <!-- Contenedor del carrusel -->
        <div class="relative overflow-hidden rounded-lg shadow-lg">
            <div id="testimonialSlider" class="flex overflow-hidden scroll-smooth snap-x snap-mandatory">
                <!-- Los testimonios se cargarán dinámicamente aquí -->
            </div>
        </div>

        <!-- Formulario de Testimonios -->
        <?php if(isset($_SESSION['login'])) : ?>
            <div class="max-w-2xl mx-auto mt-16 bg-gray-800 p-8 rounded-lg shadow-xl">
                <h3 class="text-2xl font-bold text-amber-500 mb-6">Deja tu Testimonio</h3>
                
                <form id="testimonioForm" class="space-y-6">
                    <div>
                        <label for="contenido" class="block text-gray-300 mb-2">Tu Experiencia</label>
                        <textarea 
                            id="contenido" 
                            name="contenido" 
                            rows="4" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:border-amber-500"
                            placeholder="Cuéntanos tu experiencia..."
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-300 mb-2">Calificación</label>
                        <div class="flex space-x-2">
                            <?php for($i = 1; $i <= 5; $i++) : ?>
                                <button 
                                    type="button"
                                    class="estrella text-gray-400 text-2xl hover:text-amber-500 transition-colors"
                                    data-valor="<?php echo $i; ?>"
                                >★</button>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" id="calificacion" name="calificacion" value="">
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-amber-500 text-black py-3 px-6 rounded-lg font-bold hover:bg-amber-400 transition-colors"
                    >
                        Enviar Testimonio
                    </button>
                </form>
            </div>
        <?php else : ?>
            <div class="text-center mt-16">
                <p class="text-gray-400">
                    ¿Quieres compartir tu experiencia? 
                    <a href="/login?redirect=/#testimonials" class="text-amber-500 hover:text-amber-400">Inicia sesión</a>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Script para las estrellas del formulario -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const estrellas = document.querySelectorAll('.estrella');
    const calificacionInput = document.getElementById('calificacion');

    estrellas.forEach(estrella => {
        estrella.addEventListener('click', function() {
            const valor = this.dataset.valor;
            calificacionInput.value = valor;

            // Actualizar visualización de estrellas
            estrellas.forEach(e => {
                const valorEstrella = e.dataset.valor;
                if (valorEstrella <= valor) {
                    e.classList.remove('text-gray-400');
                    e.classList.add('text-amber-500');
                } else {
                    e.classList.remove('text-amber-500');
                    e.classList.add('text-gray-400');
                }
            });
        });
    });
});
</script>

<!-- Script para cargar y mostrar testimonios -->
<script>
document.addEventListener('DOMContentLoaded', async function() {
    const slider = document.getElementById('testimonialSlider');
    
    // Función para cargar testimonios
    async function cargarTestimonios() {
        try {
            const response = await fetch('/api/testimonios');
            const testimonios = await response.json();
            
            // Limpiar slider
            slider.innerHTML = '';
            
            // Agregar testimonios
            testimonios.forEach(testimonio => {
                const card = document.createElement('div');
                card.className = 'flex-none w-full md:w-1/3 bg-gray-800 rounded-lg p-6 mx-2 snap-center testimonial-card';
                
                // Crear estrellas basadas en la calificación
                const estrellas = '★'.repeat(testimonio.calificacion) + '☆'.repeat(5 - testimonio.calificacion);
                
                card.innerHTML = `
                    <div class="text-amber-500 mb-2">${estrellas}</div>
                    <p class="text-gray-300 italic mb-4">"${testimonio.contenido}"</p>
                    <h3 class="text-lg font-bold text-amber-500">${testimonio.nombre} ${testimonio.apellido}</h3>
                    <p class="text-sm text-gray-400">${new Date(testimonio.fecha_creacion).toLocaleDateString()}</p>
                `;
                
                slider.appendChild(card);
            });

            // Clonar los primeros elementos para el carrusel infinito
            const cards = document.querySelectorAll('.testimonial-card');
            cards.forEach(card => {
                const clone = card.cloneNode(true);
                slider.appendChild(clone);
            });

        } catch (error) {
            console.error('Error al cargar testimonios:', error);
        }
    }

    // Cargar testimonios iniciales
    await cargarTestimonios();

    // Actualizar testimonios cuando se envía uno nuevo
    if(document.getElementById('testimonioForm')) {
        document.getElementById('testimonioForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const datos = {
                contenido: document.getElementById('contenido').value,
                calificacion: document.getElementById('calificacion').value
            };

            try {
                const response = await fetch('/api/testimonios', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(datos)
                });

                const resultado = await response.json();

                if(resultado.tipo === 'exito') {
                    // Limpiar formulario
                    this.reset();
                    document.querySelectorAll('.estrella').forEach(e => {
                        e.classList.remove('text-amber-500');
                        e.classList.add('text-gray-400');
                    });
                    
                    // Recargar testimonios
                    await cargarTestimonios();
                    
                    Swal.fire({
                        icon: 'success',
                        title: '¡Gracias!',
                        text: 'Tu testimonio ha sido guardado correctamente'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: resultado.mensaje
                    });
                }
            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al enviar el testimonio'
                });
            }
        });
    }

    // Animación del carrusel
    let currentPosition = 0;
    function animateSlider() {
        currentPosition += 0.8;
        slider.scrollLeft = currentPosition;

        if (currentPosition >= slider.scrollWidth / 2) {
            currentPosition = 0;
        }

        requestAnimationFrame(animateSlider);
    }

    animateSlider();
});
</script>

<!-- Sección de Contacto -->
<section id="seccionContacto" class="py-24 bg-gradient-to-br from-gray-900 to-black relative mt-12 rounded-lg">
    <div class="container mx-auto px-8">
        <!-- Encabezado -->
        <div class="text-center mb-16">
            <h2 class="text-5xl font-bold text-amber-500 mb-4">Contáctanos</h2>
            <p class="text-gray-300 text-xl">Estamos aquí para responder tus preguntas</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-start">
            <!-- Formulario de Contacto -->
            <div class="bg-black/40 backdrop-blur-sm p-8 rounded-xl border border-gray-700 transform hover:scale-[1.02] transition-all duration-300">
                <h3 class="text-2xl font-bold text-amber-500 mb-6">Envíanos un mensaje</h3>
                <form class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-300 mb-2">Nombre</label>
                            <input type="text" class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Email</label>
                            <input type="email" class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-2">Asunto</label>
                        <input type="text" class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-2">Mensaje</label>
                        <textarea rows="4" class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition-colors"></textarea>
                    </div>
                    <button class="w-full bg-amber-500 text-black py-3 px-6 rounded-lg font-bold hover:bg-amber-400 transition-colors flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Enviar Mensaje
                    </button>
                </form>
            </div>

            <!-- Información de Contacto -->
            <div class="space-y-8">
                <!-- Tarjeta de Ubicación -->
                <div class="bg-black/40 backdrop-blur-sm p-8 rounded-xl border border-gray-700 transform hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-start">
                        <div class="bg-amber-500/10 p-4 rounded-full mr-4">
                            <i class="fas fa-map-marker-alt text-2xl text-amber-500"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-white mb-2">Ubicación</h4>
                            <p class="text-gray-300">Av. Concha y Toro 2730, 8150215 Puente Alto</p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Teléfono -->
                <div class="bg-black/40 backdrop-blur-sm p-8 rounded-xl border border-gray-700 transform hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-start">
                        <div class="bg-amber-500/10 p-4 rounded-full mr-4">
                            <i class="fas fa-phone text-2xl text-amber-500"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-white mb-2">Teléfono</h4>
                            <p class="text-gray-300">+56 9 8765 4321</p>
                            <p class="text-gray-300">+56 2 2345 6789</p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Email -->
                <div class="bg-black/40 backdrop-blur-sm p-8 rounded-xl border border-gray-700 transform hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-start">
                        <div class="bg-amber-500/10 p-4 rounded-full mr-4">
                            <i class="fas fa-envelope text-2xl text-amber-500"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-white mb-2">Email</h4>
                            <p class="text-gray-300">info@elitebarbershop.cl</p>
                            <p class="text-gray-300">contacto@elitebarbershop.cl</p>
                        </div>
                    </div>
                </div>

                <!-- Mapa -->
                <div class="rounded-xl overflow-hidden h-[300px] border border-gray-700">
                    <iframe 
                        src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=INACAP+Puente+Alto&ie=UTF8&t=&z=14&iwloc=B&output=embed" 
                        width="100%" 
                        height="100%" 
                        frameborder="0" 
                        style="border:0; filter: grayscale(1) contrast(1.2);" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

      </div>
    </div>
  </div>

  <footer class="bg-gray-900 text-white pt-12 pb-8 px-4 relative mt-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
        <!-- Sección Logo y Descripción -->
        <div class="lg:col-span-2">
            <div class="flex items-center mb-6">
                <img src="/build/img/logo.svg" alt="logo_barberia" class="h-12">
                <span class="ml-3 text-2xl font-bold text-amber-500">Elite Barbershop</span>
            </div>
            <p class="text-gray-400 mb-6">
                Expertos en el arte del cuidado masculino. Ofrecemos servicios de primera calidad para que luzcas tu mejor versión.
            </p>
            <div class="flex space-x-4">
                <a href="/" class="bg-white/10 hover:bg-amber-500 p-2 rounded-full transition-colors duration-300">
                    <i class="fa-brands fa-whatsapp text-xl"></i>
                </a>
                <a href="/" class="bg-white/10 hover:bg-amber-500 p-2 rounded-full transition-colors duration-300">
                    <i class="fa-brands fa-instagram text-xl"></i>
                </a>
                <a href="/" class="bg-white/10 hover:bg-amber-500 p-2 rounded-full transition-colors duration-300">
                    <i class="fa-brands fa-facebook text-xl"></i>
                </a>
            </div>
        </div>

        <!-- Sección Contacto -->
        <div>
            <h3 class="text-lg font-bold text-amber-500 mb-6">Contacto</h3>
            <ul class="space-y-4">
                <li class="flex items-center">
                    <i class="fa-solid fa-phone text-amber-500 mr-3"></i>
                    <a href="tel:850-123-5021" class="text-gray-400 hover:text-amber-500 transition-colors">
                        850-123-5021
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fa-solid fa-envelope text-amber-500 mr-3"></i>
                    <a href="mailto:info@styloreserva.com" class="text-gray-400 hover:text-amber-500 transition-colors">
                        info@styloreserva.com
                    </a>
                </li>
                <li class="flex items-start">
                    <i class="fa-solid fa-location-dot text-amber-500 mr-3 mt-1"></i>
                    <a href="https://goo.gl/maps/..." target="_blank" class="text-gray-400 hover:text-amber-500 transition-colors">
                        Av. Concha y Toro 2730,<br>8150215 Puente Alto
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección Enlaces Rápidos -->
        <div>
            <h3 class="text-lg font-bold text-amber-500 mb-6">Enlaces Rápidos</h3>
            <ul class="space-y-4">
                <li>
                    <a href="/" class="text-gray-400 hover:text-amber-500 transition-colors flex items-center">
                        <i class="fa-solid fa-chevron-right text-xs mr-2"></i>
                        Servicios
                    </a>
                </li>
                <li>
                    <a href="/" class="text-gray-400 hover:text-amber-500 transition-colors flex items-center">
                        <i class="fa-solid fa-chevron-right text-xs mr-2"></i>
                        Reservar Cita
                    </a>
                </li>
                <li>
                    <a href="/" class="text-gray-400 hover:text-amber-500 transition-colors flex items-center">
                        <i class="fa-solid fa-chevron-right text-xs mr-2"></i>
                        Política de Privacidad
                    </a>
                </li>
                <li>
                    <a href="/" class="text-gray-400 hover:text-amber-500 transition-colors flex items-center">
                        <i class="fa-solid fa-chevron-right text-xs mr-2"></i>
                        Términos y Condiciones
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Línea divisoria -->
    <div class="max-w-7xl mx-auto border-t border-gray-800 mt-12 pt-8">
        <p class="text-center text-gray-400 text-sm">
            © 2024 Elite Barbershop. Todos los derechos reservados.
        </p>
    </div>
  </footer>
</body>
