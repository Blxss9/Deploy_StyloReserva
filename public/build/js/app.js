let paso = 1;
const pasoInicial = 1;
const pasoFinal = 4;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); // Muestra y oculta las secciones
    tabs(); // Cambia la sección cuando se presionen los tabs
    botonesPaginador(); // Agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();
    
    consultarAPI(); // Consulta la API en el backend de PHP
    
    idCliente(); // Añade el id del cliente al objeto de cita
    nombreCliente(); // Añade el nombre del cliente al objeto de cita
    seleccionarFecha(); // Añade la fecha de la cita en el objeto
    seleccionarHora(); // Añade la hora de la cita en el objeto
    
    mostrarResumen(); // Muestra el resumen de la cita
}

async function consultarAPI() {
    try {
        const url = '/api/servicios';
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        
        if(!resultado.error) {
            mostrarServicios(resultado);
        } else {
            console.error(resultado.error);
            mostrarAlerta('Error al cargar los servicios', 'error');
        }
        
    } catch (error) {
        console.error(error);
        mostrarAlerta('Error al cargar los servicios', 'error');
    }
}

function mostrarServicios(servicios) {
    const contenedorServicios = document.querySelector('#servicios');
    
    if(!contenedorServicios) {
        console.error('El contenedor de servicios no existe');
        return;
    }
    
    // Limpiar el HTML previo
    contenedorServicios.innerHTML = '';
    
    servicios.forEach(servicio => {
        const { id, nombre_servicio, precio, tiempo_estimado } = servicio;
        const precioFormateado = parseInt(precio).toLocaleString('es-CL');
        const tiempoFormateado = formatearTiempo(parseInt(tiempo_estimado));

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        servicioDiv.innerHTML = `
            <p class="nombre-servicio">${nombre_servicio}</p>
            <p class="precio-servicio">$${precioFormateado}</p>
            <p class="tiempo-servicio">Duración: ${tiempoFormateado}</p>
        `;

        servicioDiv.onclick = () => seleccionarServicio(servicio);
        contenedorServicios.appendChild(servicioDiv);
    });
}

function paginaSiguiente() {
    const btnSiguiente = document.querySelector('#siguiente');
    
    if(!btnSiguiente) return;
    
    btnSiguiente.addEventListener('click', () => {
        if(paso >= pasoFinal) return;
        
        if(paso === 1) {
            // Validar que se haya seleccionado al menos un servicio
            if(!validarServicios()) return;
        }
        
        if(paso === 2) {
            // Validar que se haya seleccionado fecha y hora
            if(!validarFecha()) return;
        }
        
        paso++;
        mostrarSeccion();
        botonesPaginador();
        
        // Actualizar el resumen al cambiar de página
        mostrarResumen();
    });
}

function paginaAnterior() {
    const btnAnterior = document.querySelector('#anterior');
    
    if(!btnAnterior) return;
    
    btnAnterior.addEventListener('click', () => {
        if(paso <= pasoInicial) return;
        
        paso--;
        mostrarSeccion();
        botonesPaginador();
    });
}

function botonesPaginador() {
    const btnAnterior = document.querySelector('#anterior');
    const btnSiguiente = document.querySelector('#siguiente');
    
    if(!btnAnterior || !btnSiguiente) return;

    if(paso === 1) {
        btnAnterior.classList.add('hidden');
    } else {
        btnAnterior.classList.remove('hidden');
    }

    if(paso === 4) {
        btnSiguiente.classList.add('hidden');
    } else {
        btnSiguiente.classList.remove('hidden');
        btnSiguiente.textContent = 'Siguiente »';
    }
}

function mostrarSeccion() {
    // Ocultar la sección que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.seccion:not(.hidden)');
    if(seccionAnterior) {
        seccionAnterior.classList.add('hidden');
    }
    
    // Seleccionar la sección con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    if(seccion) {
        seccion.classList.remove('hidden');
    }
    
    // Actualizar todos los botones de paso
    const botones = document.querySelectorAll('.step-button');
    botones.forEach((boton, index) => {
        const pasoBoton = index + 1;
        
        // Resetear clases
        boton.classList.remove('bg-blue-600', 'text-white', 'bg-gray-200', 'text-gray-400');
        
        // Colorear los botones completados y el actual
        if (pasoBoton <= paso) {
            boton.classList.add('bg-blue-600', 'text-white');
        } else {
            boton.classList.add('bg-gray-200', 'text-gray-400');
        }
    });
    
    // Actualizar la barra de progreso
    const progreso = document.querySelector('#progress');
    if(progreso) {
        const porcentaje = ((paso) / pasoFinal) * 100;
        progreso.style.width = `${porcentaje}%`;
    }
}

function mostrarAlerta(mensaje, tipo) {
    if(typeof Swal === 'undefined') {
        console.error('SweetAlert2 no está cargado');
        alert(mensaje);
        return;
    }

    Swal.fire({
        icon: tipo,
        title: tipo === 'error' ? 'Error' : 'Éxito',
        text: mensaje
    });
}

function tabs() {
    const botones = document.querySelectorAll('.step-button');
    botones.forEach(boton => {
        boton.addEventListener('click', function(e) {
            const pasoSeleccionado = parseInt(e.target.dataset.paso);
            
            // Si intenta retroceder, permitirlo
            if (pasoSeleccionado < paso) {
                paso = pasoSeleccionado;
                mostrarSeccion();
                botonesPaginador();
                return;
            }

            // Validaciones para avanzar
            if (paso === 1 && !validarServicios()) {
                return;
            }

            if (paso === 2 && !validarFecha()) {
                return;
            }

            // Si todas las validaciones pasan, permitir el cambio
            if (pasoSeleccionado - paso === 1) {
                paso = pasoSeleccionado;
                mostrarSeccion();
                botonesPaginador();
            } else {
                // Si intenta saltar más de una sección, mostrar alerta
                mostrarAlerta('Por favor, complete los pasos en orden', 'error');
            }
        });
    });
}

function validarServicios() {
    if(cita.servicios.length === 0) {
        mostrarAlerta('Debes seleccionar al menos un servicio', 'error');
        return false;
    }
    return true;
}

function validarFecha() {
    const fecha = document.querySelector('#fecha').value;
    
    if(fecha === '' || !cita.hora) {
        mostrarAlerta('Debes seleccionar fecha y hora', 'error');
        return false;
    }
    
    return true;
}

function validarResumen() {
    const elementos = Object.values(cita);
    if(elementos.includes('')) {
        mostrarAlerta('Faltan datos por confirmar', 'error');
        return false;
    }
    return true;
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    // Identificar el elemento clickeado
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya fue agregado o quitarlo
    if(servicios.some(agregado => agregado.id === id)) {
        // Eliminarlo
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    } else {
        // Agregarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
    
    // Actualizar el resumen cada vez que se selecciona o deselecciona un servicio
    mostrarResumen();
}

// También necesitamos implementar las funciones de cliente
function idCliente() {
    // Verificar si el elemento existe antes de acceder a su valor
    const inputId = document.querySelector('#id');
    if(inputId) {
        cita.id = inputId.value;
    }
}

function nombreCliente() {
    // Verificar si el elemento existe antes de acceder a su valor
    const inputNombre = document.querySelector('#nombre');
    if(inputNombre) {
        cita.nombre = inputNombre.value;
    }
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    const horasDisponibles = document.querySelector('#horas-disponibles');
    
    if(!inputFecha || !horasDisponibles) {
        console.error('No se encontraron los elementos necesarios');
        return;
    }
    
    // Establecer la fecha mínima como hoy
    const hoy = new Date();
    const año = hoy.getFullYear();
    const mes = (hoy.getMonth() + 1).toString().padStart(2, '0');
    const dia = hoy.getDate().toString().padStart(2, '0');
    const fechaMinima = `${año}-${mes}-${dia}`;
    
    inputFecha.min = fechaMinima;
    
    inputFecha.addEventListener('input', function(e) {
        const fechaSeleccionada = new Date(e.target.value + 'T00:00:00');
        const fechaHoy = new Date(fechaMinima + 'T00:00:00');
        
        if(fechaSeleccionada < fechaHoy) {
            e.target.value = '';
            mostrarAlerta('No puedes seleccionar fechas pasadas', 'error');
            horasDisponibles.classList.add('hidden');
            cita.fecha = '';
            cita.hora = '';
        } else {
            const dia = fechaSeleccionada.getUTCDay();
            
            if([6, 0].includes(dia)) {
                e.target.value = '';
                mostrarAlerta('Fines de semana no permitidos', 'error');
                horasDisponibles.classList.add('hidden');
                cita.fecha = '';
                cita.hora = '';
            } else {
                cita.fecha = e.target.value;
                mostrarHorasDisponibles();
            }
        }
        // Actualizar el resumen cuando se selecciona una fecha
        mostrarResumen();
    });
}

function mostrarHorasDisponibles() {
    const horasDisponibles = document.querySelector('#horas-disponibles');
    
    if(!horasDisponibles) {
        console.error('No se encontró el contenedor de horas disponibles');
        return;
    }
    
    horasDisponibles.classList.remove('hidden');

    // Definir las horas disponibles por período
    const horas = {
        mañana: ['10:00', '10:50', '11:40'],
        tarde: ['12:30', '15:00', '15:50', '16:40', '17:30'],
        noche: ['18:20', '19:10']
    };

    // Obtener la fecha seleccionada y la fecha actual
    const fechaSeleccionada = new Date(cita.fecha + 'T00:00:00');
    const ahora = new Date();
    const esHoy = fechaSeleccionada.toDateString() === ahora.toDateString();

    // Limpiar contenedores
    ['mañana', 'tarde', 'noche'].forEach(periodo => {
        const contenedor = document.querySelector(`#horas-${periodo}`);
        if(!contenedor) {
            console.error(`No se encontró el contenedor para ${periodo}`);
            return;
        }
        
        contenedor.innerHTML = '';
        
        horas[periodo].forEach(async (hora) => {
            const boton = document.createElement('BUTTON');
            boton.type = 'button';
            boton.classList.add('px-4', 'py-2', 'text-sm', 'border', 'rounded', 'hover:bg-blue-500', 'hover:text-white');
            
            // Verificar si la hora ya pasó (solo si es hoy)
            const [horaNum, minutos] = hora.split(':');
            const horaComparar = new Date(fechaSeleccionada);
            horaComparar.setHours(parseInt(horaNum), parseInt(minutos), 0);
            
            const horaYaPaso = esHoy && horaComparar <= ahora;
            
            // Verificar disponibilidad solo si la hora no ha pasado
            const disponible = !horaYaPaso && await verificarDisponibilidad(cita.fecha, hora);
            
            if (!disponible || horaYaPaso) {
                boton.classList.add('bg-gray-200', 'cursor-not-allowed', 'opacity-50');
                boton.disabled = true;
                boton.title = horaYaPaso ? 'Esta hora ya pasó' : 'Horario no disponible';
            }
            
            if(cita.hora === hora) {
                boton.classList.add('bg-blue-500', 'text-white');
            }
            
            boton.textContent = hora;
            
            boton.onclick = function() {
                if (disponible && !horaYaPaso) {
                    document.querySelectorAll('button[type="button"]').forEach(btn => {
                        btn.classList.remove('bg-blue-500', 'text-white');
                    });
                    
                    this.classList.add('bg-blue-500', 'text-white');
                    cita.hora = hora;
                    
                    mostrarResumen();
                }
            };
            
            contenedor.appendChild(boton);
        });
    });
}

// Función para verificar disponibilidad
async function verificarDisponibilidad(fecha, hora) {
    try {
        const url = `/api/disponibilidad?fecha=${fecha}&hora=${hora}`;
        console.log('Verificando disponibilidad para:', { fecha, hora });
        
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        console.log('Respuesta del servidor:', resultado);
        
        if (resultado.error) {
            console.error('Error:', resultado.error);
            return false;
        }
        
        return resultado.disponible;
    } catch (error) {
        console.error('Error al verificar disponibilidad:', error);
        return false;
    }
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e) {
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        if(hora < 10 || hora > 18) {
            e.target.value = '';
            mostrarAlerta('Hora no válida', 'error');
        } else {
            cita.hora = e.target.value;
        }
    });
}

function formatearTiempo(minutos) {
    if (minutos >= 60) {
        const horas = Math.floor(minutos / 60);
        const minutosRestantes = minutos % 60;
        
        if (minutosRestantes === 0) {
            return `${horas} ${horas === 1 ? 'hora' : 'horas'}`;
        } else {
            return `${horas} ${horas === 1 ? 'hora' : 'horas'} y ${minutosRestantes} ${minutosRestantes === 1 ? 'minuto' : 'minutos'}`;
        }
    }
    return `${minutos} ${minutos === 1 ? 'minuto' : 'minutos'}`;
}

function mostrarResumen() {
    const resumen = document.querySelector('#resumen-cita');

    // Limpiar el contenido
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    // Verificar si hay servicios seleccionados y datos completos
    if(Object.values(cita).includes('') || cita.servicios.length === 0) {
        return;
    }

    const { nombre, fecha, hora, servicios } = cita;

    // Contenedor principal
    const contenedorResumen = document.createElement('DIV');
    contenedorResumen.classList.add('p-6', 'space-y-6');

    // Nombre del cliente
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span class="font-bold">Cliente:</span> ${nombre}`;
    nombreCliente.classList.add('text-lg');

    // Contenedor de servicios
    const contenedorServicios = document.createElement('DIV');
    contenedorServicios.classList.add('space-y-3');

    // Título de servicios
    const tituloServicios = document.createElement('H3');
    tituloServicios.textContent = 'Servicios Seleccionados:';
    tituloServicios.classList.add('font-bold', 'text-lg', 'mb-3');
    contenedorServicios.appendChild(tituloServicios);

    // Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const { nombre_servicio, precio, tiempo_estimado } = servicio;
        const servicioParrafo = document.createElement('P');
        const precioFormateado = new Intl.NumberFormat('es-CL', {
            style: 'currency',
            currency: 'CLP'
        }).format(precio);
        const tiempoFormateado = formatearTiempo(parseInt(tiempo_estimado));
        servicioParrafo.textContent = `${nombre_servicio} - ${tiempoFormateado} - ${precioFormateado}`;
        contenedorServicios.appendChild(servicioParrafo);
    });

    // Calcular y mostrar el tiempo total
    const tiempoTotal = servicios.reduce((total, servicio) => total + parseInt(servicio.tiempo_estimado), 0);
    const tiempoParrafo = document.createElement('P');
    const tiempoTotalFormateado = formatearTiempo(tiempoTotal);
    tiempoParrafo.innerHTML = `<span class="font-bold">Tiempo Total:</span> ${tiempoTotalFormateado}`;
    tiempoParrafo.classList.add('text-lg', 'mt-3');

    // Formatear la fecha
    const fechaObj = new Date(fecha + 'T00:00:00');  // Añadir T00:00:00 para forzar hora local
    const opciones = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        timeZone: 'America/Santiago'  // Especificar zona horaria de Chile
    };
    const fechaFormateada = fechaObj.toLocaleDateString('es-CL', opciones);
    // Capitalizar primera letra
    const fechaCapitalizada = fechaFormateada.charAt(0).toUpperCase() + fechaFormateada.slice(1);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span class="font-bold">Fecha:</span> ${fechaCapitalizada}`;
    fechaCita.classList.add('text-lg');

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span class="font-bold">Hora:</span> ${hora} hrs`;
    horaCita.classList.add('text-lg');

    // Calcular y mostrar el total
    const total = servicios.reduce((total, servicio) => total + parseFloat(servicio.precio), 0);
    const totalFormateado = new Intl.NumberFormat('es-CL', {
        style: 'currency',
        currency: 'CLP'
    }).format(total);
    
    const totalParrafo = document.createElement('P');
    totalParrafo.innerHTML = `<span class="font-bold">Total:</span> ${totalFormateado}`;
    totalParrafo.classList.add('text-xl', 'mt-6');

    // Agregar al contenedor principal
    contenedorResumen.appendChild(nombreCliente);
    contenedorResumen.appendChild(contenedorServicios);
    contenedorResumen.appendChild(fechaCita);
    contenedorResumen.appendChild(horaCita);
    contenedorResumen.appendChild(tiempoParrafo);
    contenedorResumen.appendChild(totalParrafo);

    // Agregar al resumen
    resumen.appendChild(contenedorResumen);
}

function toggleAccordion(id) {
    const content = document.getElementById(id);
    const arrow = document.getElementById(`arrow-${id.split('-')[1]}`);
    
    // Oculta todos los contenidos
    document.querySelectorAll('[id^="pago-"]').forEach(elem => {
        if (elem.id !== id) {
            elem.classList.add('hidden');
        }
    });
    
    // Muestra/oculta el contenido seleccionado
    content.classList.toggle('hidden');
    
    // Rota la flecha
    if (content.classList.contains('hidden')) {
        arrow.style.transform = 'rotate(0deg)';
    } else {
        arrow.style.transform = 'rotate(180deg)';
        // Reinicializa PayPal si es necesario
        if (id === 'pago-paypal' && !content.classList.contains('hidden')) {
            const paypalContainer = document.getElementById('paypal-button-container');
            paypalContainer.innerHTML = ''; // Limpia el contenedor
            initPayPal();
        }
    }
}

// Función para inicializar PayPal
function initPayPal() {
    if (window.paypal) {
        paypal.Buttons({
            createOrder: async () => {
                try {
                    const response = await fetch('/api/orders', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            servicios: cita.servicios,
                            fecha: cita.fecha,
                            hora: cita.hora,
                            usuarioId: cita.id
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Error al crear la orden');
                    }

                    const data = await response.json();
                    return data.id;
                } catch (error) {
                    console.error('Error:', error);
                    mostrarAlerta('Error al procesar el pago', 'error');
                }
            },
            onApprove: async (data) => {
                try {
                    const response = await fetch(`/api/orders/capture/${data.orderID}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Error en la captura del pago');
                    }

                    const resultado = await response.json();
                    
                    if (resultado.status === 'success') {
                        // Mostrar alerta con opciones
                        Swal.fire({
                            icon: 'success',
                            title: '¡Pago Exitoso!',
                            text: 'Tu cita ha sido agendada y pagada correctamente',
                            showCancelButton: true,
                            confirmButtonText: 'Ver Comprobante',
                            cancelButtonText: 'Nueva Cita',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#6b7280'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Ir al comprobante
                                window.location.href = resultado.comprobanteUrl;
                            } else {
                                // Recargar la página para nueva cita
                                window.location.reload();
                            }
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message
                    });
                }
            },
            onError: (err) => {
                console.error('Error PayPal:', err);
                mostrarAlerta('Error en el proceso de pago', 'error');
            }
        }).render('#paypal-button-container');
    } else {
        console.error('PayPal SDK no está cargado');
        mostrarAlerta('Error al cargar PayPal', 'error');
    }
}

function mostrarComprobante(datos) {
    const modalHTML = `
        <div id="modal-comprobante" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Comprobante de Pago</h3>
                    <div class="mt-2 px-7 py-3">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-2">
                                <span class="font-bold">Número de Orden:</span> 
                                ${datos.ordenId}
                            </p>
                            <p class="text-sm text-gray-600 mb-2">
                                <span class="font-bold">Fecha:</span> 
                                ${datos.fecha}
                            </p>
                            <p class="text-sm text-gray-600 mb-2">
                                <span class="font-bold">Hora:</span> 
                                ${datos.hora}
                            </p>
                            <p class="text-sm text-gray-600 mb-2">
                                <span class="font-bold">Total Pagado:</span> 
                                ${datos.total}
                            </p>
                            <div class="mt-3">
                                <h4 class="font-bold text-sm mb-2">Servicios:</h4>
                                ${datos.servicios.map(servicio => `
                                    <p class="text-sm text-gray-600">
                                        ${servicio.nombre} - ${servicio.precio}
                                    </p>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button id="btn-descargar" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Descargar PDF
                        </button>
                        <button id="btn-cerrar" class="mt-3 px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Agregar el modal al DOM
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Agregar event listeners
    document.getElementById('btn-cerrar').addEventListener('click', () => {
        document.getElementById('modal-comprobante').remove();
        window.location.reload();
    });

    document.getElementById('btn-descargar').addEventListener('click', () => {
        descargarComprobantePDF(datos);
    });
}

// Inicializar PayPal cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    // ... resto del código de inicialización ...
    
    // Inicializar PayPal si estamos en el paso de pago
    if (paso === 4) {
        initPayPal();
    }
});

// Configurar el botón de agendar
document.getElementById('btn-agendar')?.addEventListener('click', async () => {
    // Mostrar modal de confirmación
    Swal.fire({
        title: '¿Confirmar Cita?',
        html: `
            <div class="text-left">
                <p class="mb-2"><strong>Fecha:</strong> ${formatearFecha(cita.fecha)}</p>
                <p class="mb-2"><strong>Hora:</strong> ${cita.hora}</p>
                <p class="mb-2"><strong>Servicios:</strong></p>
                <ul class="list-disc pl-5">
                    ${cita.servicios.map(servicio => 
                        `<li>${servicio.nombre_servicio} - ${formatearPrecio(servicio.precio)}</li>`
                    ).join('')}
                </ul>
                <p class="mt-2"><strong>Total:</strong> ${formatearPrecio(calcularTotal(cita.servicios))}</p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, Confirmar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await fetch('/api/citas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        ...cita,
                        servicios: cita.servicios.map(s => s.id).join(','),
                        pago: 'PENDING',
                        estado: 'pendiente'
                    })
                });

                const resultado = await response.json();
                
                if(resultado.resultado) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Cita Agendada!',
                        text: 'Tu cita ha sido agendada correctamente, nos contactaremos contigo para confirmar tu asistencia.',
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'Nueva Cita',
                        confirmButtonColor: '#3085d6',
                        footer: '<a href="/" class="text-gray-500 hover:text-gray-700">Volver al inicio</a>'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Recargar para nueva cita
                            window.location.reload();
                        }
                    });
                }
            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al agendar la cita'
                });
            }
        }
    });
});

// Función auxiliar para formatear la fecha
function formatearFecha(fecha) {
    const opciones = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        timeZone: 'America/Santiago'  // Especificar zona horaria de Chile
    };
    
    let fechaFormateada = new Date(fecha + 'T00:00:00').toLocaleDateString('es-ES', opciones);
    return fechaFormateada.charAt(0).toUpperCase() + fechaFormateada.slice(1);
}

// Función auxiliar para formatear precio en CLP
function formatearPrecio(precio) {
    return new Intl.NumberFormat('es-CL', {
        style: 'currency',
        currency: 'CLP',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(precio);
}

// Función auxiliar para calcular el total
function calcularTotal(servicios) {
    return servicios.reduce((total, servicio) => 
        total + parseFloat(servicio.precio), 0
    );
}


//# sourceMappingURL=app.js.map
