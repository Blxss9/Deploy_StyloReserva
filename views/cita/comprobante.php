<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Comprobante de Pago</h1>
                <p class="text-gray-600">Gracias por tu reserva</p>
            </div>

            <div class="space-y-6">
                <!-- Número de Orden -->
                <div class="flex justify-between items-center border-b pb-4">
                    <span class="font-semibold text-gray-700">Número de Orden:</span>
                    <span class="text-gray-600"><?php echo $comprobante['ordenId']; ?></span>
                </div>

                <!-- Fecha y Hora -->
                <div class="flex justify-between items-center border-b pb-4">
                    <span class="font-semibold text-gray-700">Fecha:</span>
                    <span class="text-gray-600"><?php echo $comprobante['fecha']; ?></span>
                </div>
                <div class="flex justify-between items-center border-b pb-4">
                    <span class="font-semibold text-gray-700">Hora:</span>
                    <span class="text-gray-600"><?php echo $comprobante['hora']; ?> hrs</span>
                </div>

                <!-- Servicios -->
                <div class="border-b pb-4">
                    <h3 class="font-semibold text-gray-700 mb-4">Servicios:</h3>
                    <div class="space-y-2">
                        <?php foreach ($comprobante['servicios'] as $servicio): ?>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600"><?php echo $servicio['nombre']; ?></span>
                                <span class="text-gray-600">$<?php echo $servicio['precio']; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Total -->
                <div class="flex justify-between items-center pt-4">
                    <span class="font-bold text-lg text-gray-800">Total:</span>
                    <span class="font-bold text-lg text-gray-800"><?php echo $comprobante['total']; ?></span>
                </div>

                <!-- Botones -->
                <div class="flex justify-center gap-4 mt-8">
                    <a href="/cita" 
                       class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Nueva Cita
                    </a>
                    <a href="/" 
                       class="bg-amber-500 text-white px-6 py-2 rounded-lg hover:bg-amber-600 transition-colors">Inicio
                       <i class="fa-solid fa-house"></i>
                    </a>
                    <button onclick="window.print()" 
                            class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>