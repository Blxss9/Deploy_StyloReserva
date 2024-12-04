<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Servicios Disponibles</h2>
        <button 
            id="nuevo-servicio" 
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
            Nuevo Servicio
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duración</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach($servicios as $servicio) { ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $servicio->nombre_servicio; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">$<?php echo number_format($servicio->precio, 0, ',', '.'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $servicio->tiempo_estimado; ?> min</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button class="editar-servicio text-blue-600 hover:text-blue-900 mr-3" data-id="<?php echo $servicio->id; ?>">Editar</button>
                            <button class="eliminar-servicio text-red-600 hover:text-red-900" data-id="<?php echo $servicio->id; ?>">Eliminar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
