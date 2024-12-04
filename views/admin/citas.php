<!-- Dashboard Stats Generales -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-gray-600 text-sm">Total Citas</h2>
                <p class="text-2xl font-semibold text-gray-800"><?php echo count($todasLasCitas); ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-gray-600 text-sm">Citas Pendientes</h2>
                <p class="text-2xl font-semibold text-gray-800"><?php echo count(array_filter($todasLasCitas, fn($cita) => $cita->estado === 'pendiente')); ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-gray-600 text-sm">Citas Confirmadas</h2>
                <p class="text-2xl font-semibold text-gray-800"><?php echo count(array_filter($todasLasCitas, fn($cita) => $cita->estado === 'confirmada')); ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-gray-600 text-sm">Citas Completadas</h2>
                <p class="text-2xl font-semibold text-gray-800"><?php echo count(array_filter($todasLasCitas, fn($cita) => $cita->estado === 'completada')); ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-gray-600 text-sm">Citas Canceladas</h2>
                <p class="text-2xl font-semibold text-gray-800"><?php echo count(array_filter($todasLasCitas, fn($cita) => $cita->estado === 'cancelada')); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Filtros y Búsqueda -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Buscador -->
        <div class="md:w-1/3">
            <form class="flex gap-2">
                <input 
                    type="text" 
                    name="buscar" 
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                    placeholder="Buscar Cliente..."
                    value="<?php echo $busqueda; ?>"
                >
                <?php if($fecha): ?>
                    <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                <?php endif; ?>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    Buscar
                </button>
                <?php if($fecha || $busqueda): ?>
                    <a href="/admin" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        Limpiar
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Selector de fecha -->
        <div class="md:w-1/3">
            <input 
                type="date" 
                id="fecha"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                value="<?php echo $fecha; ?>"
            >
        </div>
    </div>
</div>

<!-- Listado de Citas -->
<div class="bg-white rounded-lg shadow-md">
    <?php if(count($citas) === 0) { ?>
        <p class="text-center py-10 text-gray-600">No hay citas para esta fecha</p>
    <?php } else { ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
            <?php foreach($citas as $cita) { ?>
                <div class="border rounded-lg overflow-hidden">
                    <!-- Cabecera de la cita -->
                    <div class="bg-gray-50 px-4 py-2 border-b">
                        <div class="flex justify-between items-center">
                            <p class="font-semibold text-gray-700">
                                <?php echo date('H:i', strtotime($cita->hora)); ?>
                            </p>
                            <span class="estado-badge px-3 py-1 rounded-full text-sm font-medium
                                <?php echo match($cita->estado) {
                                    'pendiente' => 'bg-yellow-100 text-yellow-800',
                                    'completada' => 'bg-green-100 text-green-800',
                                    'cancelada' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                }; ?>">
                                <?php echo ucfirst($cita->estado); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Contenido de la cita -->
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2"><?php echo $cita->cliente; ?></h3>
                        
                        <div class="space-y-2 text-sm text-gray-600">
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <?php echo $cita->email; ?>
                            </p>
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <?php echo $cita->telefono; ?>
                            </p>
                            <div class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                <span><?php echo $cita->servicios; ?></span>
                            </div>
                        </div>

                        <!-- Selector de estado -->
                        <div class="mt-4">
                            <select 
                                class="estado-cita w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                data-cita-id="<?php echo $cita->id; ?>"
                            >
                                <option value="pendiente" <?php echo $cita->estado === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="confirmada" <?php echo $cita->estado === 'confirmada' ? 'selected' : ''; ?>>Confirmada</option>
                                <option value="completada" <?php echo $cita->estado === 'completada' ? 'selected' : ''; ?>>Completada</option>
                                <option value="cancelada" <?php echo $cita->estado === 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                            </select>
                        </div>

                        <!-- Total -->
                        <div class="mt-4 pt-4 border-t">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total</span>
                                <span class="text-lg font-semibold">$<?php echo number_format($cita->total, 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
