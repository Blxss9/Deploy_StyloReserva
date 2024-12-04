<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Gestión de Usuarios</h2>
        <div class="flex gap-4">
            <input 
                type="text" 
                placeholder="Buscar usuario..." 
                class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach($usuarios as $usuario) { ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php echo $usuario->nombre . ' ' . $usuario->apellido; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $usuario->email; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $usuario->telefono; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $usuario->confirmado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo $usuario->confirmado ? 'Confirmado' : 'Pendiente'; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button class="ver-usuario text-blue-600 hover:text-blue-900 mr-3" data-id="<?php echo $usuario->id; ?>">Ver Detalles</button>
                            <?php if(!$usuario->admin) { ?>
                                <button class="editar-usuario text-yellow-600 hover:text-yellow-900 mr-3" data-id="<?php echo $usuario->id; ?>">Editar</button>
                                <button class="eliminar-usuario text-red-600 hover:text-red-900" data-id="<?php echo $usuario->id; ?>">Eliminar</button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
