document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    buscarPorFecha();
    cambiarEstadoCita();
    manejarTabs();
    gestionarServicios();
    gestionarUsuarios();
}

function buscarPorFecha() {
    const fechaInput = document.querySelector('#fecha');
    if(fechaInput) {
        fechaInput.addEventListener('input', function(e) {
            const fechaSeleccionada = e.target.value;
            window.location = `?fecha=${fechaSeleccionada}`;
        });

        // Agregar evento al botón limpiar
        const btnLimpiar = document.querySelector('a[href="/admin"]');
        if(btnLimpiar) {
            btnLimpiar.addEventListener('click', function(e) {
                e.preventDefault();
                // Limpiar el input de fecha
                fechaInput.value = '';
                // Redirigir a admin sin parámetros
                window.location = '/admin';
            });
        }
    }
}

function cambiarEstadoCita() {
    const selectores = document.querySelectorAll('.estado-cita');
    selectores.forEach(selector => {
        selector.addEventListener('change', async function(e) {
            const citaId = this.dataset.citaId;
            const estado = this.value;

            try {
                const datos = new FormData();
                datos.append('id', citaId);
                datos.append('estado', estado);

                const url = '/api/citas/estado';
                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if(resultado.tipo === 'exito') {
                    // Actualizar el badge de estado
                    const citaElement = this.closest('.border');
                    const badge = citaElement.querySelector('.estado-badge');
                    
                    // Remover clases anteriores
                    badge.classList.remove(
                        'bg-yellow-100', 'text-yellow-800',
                        'bg-blue-100', 'text-blue-800',
                        'bg-green-100', 'text-green-800',
                        'bg-red-100', 'text-red-800'
                    );
                    
                    // Agregar nuevas clases según el estado
                    const clases = {
                        'pendiente': ['bg-yellow-100', 'text-yellow-800'],
                        'confirmada': ['bg-blue-100', 'text-blue-800'],
                        'completada': ['bg-green-100', 'text-green-800'],
                        'cancelada': ['bg-red-100', 'text-red-800']
                    };
                    
                    badge.classList.add(...clases[estado]);
                    badge.textContent = estado.charAt(0).toUpperCase() + estado.slice(1);

                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Estado Actualizado',
                        text: 'El estado de la cita se actualizó correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Recargar la página para actualizar los stats
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al actualizar el estado'
                });
            }
        });
    });
}

function manejarTabs() {
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remover clases activas de todas las tabs
            tabs.forEach(t => {
                t.classList.remove('border-blue-500', 'text-blue-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });

            // Ocultar todos los contenidos
            contents.forEach(content => {
                content.classList.add('hidden');
            });

            // Activar la tab seleccionada
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-blue-500', 'text-blue-600');
            
            // Mostrar el contenido correspondiente
            const tabId = this.dataset.tab;
            const contenidoActivo = document.querySelector(`#${tabId}-tab`);
            if(contenidoActivo) {
                contenidoActivo.classList.remove('hidden');
            }
        });
    });
}

function gestionarServicios() {
    // Nuevo servicio
    const btnNuevoServicio = document.querySelector('#nuevo-servicio');
    if(btnNuevoServicio) {
        btnNuevoServicio.addEventListener('click', mostrarFormularioServicio);
    }

    // Editar servicio
    const btnsEditar = document.querySelectorAll('.editar-servicio');
    btnsEditar.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            editarServicio(id);
        });
    });

    // Eliminar servicio
    const btnsEliminar = document.querySelectorAll('.eliminar-servicio');
    btnsEliminar.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            confirmarEliminarServicio(id);
        });
    });
}

function mostrarFormularioServicio(servicio = {}) {
    Swal.fire({
        title: servicio.id ? 'Editar Servicio' : 'Nuevo Servicio',
        html: `
            <form id="formulario-servicio" class="space-y-4">
                <input type="hidden" name="id" value="${servicio.id || ''}">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre del Servicio</label>
                    <input type="text" name="nombre_servicio" 
                           class="mt-1 block w-full rounded-md border-gray-300" 
                           value="${servicio.nombre_servicio || ''}" 
                           required 
                           minlength="3"
                           
                           title="Solo se permiten letras y espacios">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Precio</label>
                    <input type="number" name="precio" 
                           class="mt-1 block w-full rounded-md border-gray-300" 
                           value="${servicio.precio || ''}" 
                           required 
                           min="3000"
                           max="100000"
                           step="1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tiempo Estimado (minutos)</label>
                    <input type="number" name="tiempo_estimado" 
                           class="mt-1 block w-full rounded-md border-gray-300" 
                           value="${servicio.tiempo_estimado || ''}" 
                           required 
                           min="1"
                           step="1">
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: servicio.id ? 'Actualizar' : 'Crear',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const form = document.getElementById('formulario-servicio');
            if(!form.checkValidity()) {
                form.reportValidity();
                return false;
            }
            const formData = new FormData(form);
            return guardarServicio(formData, servicio.id);
        }
    });
}

async function guardarServicio(formData, id) {
    try {
        const url = id ? '/api/servicios/actualizar' : '/api/servicios/crear';
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        const resultado = await response.json();

        if(resultado.tipo === 'exito') {
            Swal.fire('¡Éxito!', resultado.mensaje, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            Swal.fire('Error', resultado.mensaje, 'error');
        }
    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'Hubo un error al procesar la solicitud', 'error');
    }
}

async function editarServicio(id) {
    try {
        const response = await fetch(`/api/servicios/${id}`);
        const servicio = await response.json();
        mostrarFormularioServicio(servicio);
    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'No se pudo cargar el servicio', 'error');
    }
}

function confirmarEliminarServicio(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarServicio(id);
        }
    });
}

async function eliminarServicio(id) {
    try {
        const formData = new FormData();
        formData.append('id', id);

        const response = await fetch('/api/servicios/eliminar', {
            method: 'POST',
            body: formData
        });
        const resultado = await response.json();

        if(resultado.tipo === 'exito') {
            Swal.fire('¡Eliminado!', resultado.mensaje, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            Swal.fire('Error', resultado.mensaje, 'error');
        }
    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'Hubo un error al eliminar el servicio', 'error');
    }
}

function gestionarUsuarios() {
    // Botones Ver Detalles
    const btnsVerDetalles = document.querySelectorAll('.ver-usuario');
    btnsVerDetalles.forEach(btn => {
        btn.addEventListener('click', async function() {
            const id = this.dataset.id;
            try {
                const response = await fetch(`/api/usuarios?id=${id}`);
                const usuario = await response.json();
                
                if(usuario) {
                    // Validar que los datos existan antes de mostrarlos
                    const nombreCompleto = `${usuario.nombre || ''} ${usuario.apellido || ''}`.trim();
                    const fechaRegistro = usuario.fecha_creacion ? new Date(usuario.fecha_creacion).toLocaleDateString() : 'No disponible';
                    const fechaActualizacion = usuario.ultima_actualizacion ? new Date(usuario.ultima_actualizacion).toLocaleDateString() : 'No disponible';

                    Swal.fire({
                        title: 'Detalles del Usuario',
                        html: `
                            <div class="text-left">
                                <p class="mb-2"><strong>Nombre:</strong> ${nombreCompleto || 'No disponible'}</p>
                                <p class="mb-2"><strong>Email:</strong> ${usuario.email || 'No disponible'}</p>
                                <p class="mb-2"><strong>Teléfono:</strong> ${usuario.telefono || 'No disponible'}</p>
                                <p class="mb-2"><strong>Estado:</strong> ${usuario.confirmado ? 'Confirmado' : 'Pendiente'}</p>
                                <p class="mb-2"><strong>Rol:</strong> ${usuario.admin ? 'Administrador' : 'Cliente'}</p>
                                <p class="mb-2"><strong>Fecha de registro:</strong> ${fechaRegistro}</p>
                                <p class="mb-2"><strong>Última actualización:</strong> ${fechaActualizacion}</p>
                            </div>
                        `,
                        confirmButtonText: 'Cerrar',
                        customClass: {
                            confirmButton: 'bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors'
                        }
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información del usuario'
                });
            }
        });
    });

    // Editar usuario
    const btnsEditar = document.querySelectorAll('.editar-usuario');
    btnsEditar.forEach(btn => {
        btn.addEventListener('click', async function() {
            const id = this.dataset.id;
            try {
                const response = await fetch(`/api/usuarios?id=${id}`);
                const usuario = await response.json();
                
                if(usuario) {
                    mostrarFormularioUsuario(usuario);
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información del usuario'
                });
            }
        });
    });

    // Eliminar usuario
    const btnsEliminar = document.querySelectorAll('.eliminar-usuario');
    btnsEliminar.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará al usuario y todas sus citas. No podrás revertir esto.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarUsuario(id);
                }
            });
        });
    });
}

function mostrarFormularioUsuario(usuario) {
    Swal.fire({
        title: 'Editar Usuario',
        html: `
            <form id="formulario-usuario" class="space-y-4">
                <input type="hidden" name="id" value="${usuario.id}">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" 
                           class="mt-1 block w-full rounded-md border-gray-300" 
                           value="${usuario.nombre || ''}" 
                           required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input type="text" name="apellido" 
                           class="mt-1 block w-full rounded-md border-gray-300" 
                           value="${usuario.apellido || ''}" 
                           required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" 
                           class="mt-1 block w-full rounded-md border-gray-300" 
                           value="${usuario.email || ''}" 
                           required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input type="tel" name="telefono" 
                           class="mt-1 block w-full rounded-md border-gray-300" 
                           value="${usuario.telefono || ''}" 
                           required 
                           pattern="[0-9]{9}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Estado de la cuenta</label>
                    <select name="confirmado" 
                            class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="0" ${!usuario.confirmado ? 'selected' : ''}>Pendiente</option>
                        <option value="1" ${usuario.confirmado ? 'selected' : ''}>Confirmada</option>
                    </select>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Actualizar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const form = document.getElementById('formulario-usuario');
            if(!form.checkValidity()) {
                form.reportValidity();
                return false;
            }
            const formData = new FormData(form);
            return actualizarUsuario(formData);
        }
    });
}

async function actualizarUsuario(formData) {
    try {
        const response = await fetch('/api/usuarios/actualizar', {
            method: 'POST',
            body: formData
        });
        const resultado = await response.json();

        if(resultado.tipo === 'exito') {
            Swal.fire({
                icon: 'success',
                title: '¡Usuario actualizado!',
                text: resultado.mensaje,
                showConfirmButton: false,
                timer: 1500
            });

            setTimeout(() => {
                window.location.reload();
            }, 1500);
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
            text: 'Hubo un error al actualizar el usuario'
        });
    }
}

async function eliminarUsuario(id) {
    try {
        const datos = new FormData();
        datos.append('id', id);

        const response = await fetch('/api/usuarios/eliminar', {
            method: 'POST',
            body: datos
        });
        const resultado = await response.json();

        if(resultado.tipo === 'exito') {
            Swal.fire({
                icon: 'success',
                title: '¡Usuario eliminado!',
                text: resultado.mensaje,
                showConfirmButton: false,
                timer: 1500
            });

            // Recargar la página después de 1.5 segundos
            setTimeout(() => {
                window.location.reload();
            }, 1500);
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
            text: 'Hubo un error al eliminar el usuario'
        });
    }
}


