<script src="/build/js/admin.js" defer></script>


<div class="bg-gray-100 min-h-screen">
    <!-- Header del Panel -->
    <header class="admin-header">
        <div class="admin-header-container">
            <div class="admin-header-left">
                <div class="admin-logo">
                    <i class="fas fa-cut"></i>
                    <span>StyloReserva | Panel de Administración</span>
                </div>
            </div>
            
            <div class="admin-header-right">
                <div class="admin-user">
                    <span class="admin-user-name"><?php echo $_SESSION['nombre'] ?? ''; ?></span>
                    <div class="admin-user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <a href="/logout" class="admin-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </div>
    </header>

    <style>
        .admin-header {
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-header-left {
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .admin-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
        }

        .admin-logo i {
            color: #00b09b;
        }

        .admin-nav {
            display: flex;
            gap: 1.5rem;
        }

        .admin-nav a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #4a5568;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .admin-nav a:hover {
            background: #f7fafc;
            color: #00b09b;
        }

        .admin-nav a.active {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            color: white;
        }

        .admin-header-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-user-name {
            font-weight: 500;
            color: #2d3748;
        }

        .admin-user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #00b09b, #96c93d);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .admin-logout {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #e53e3e;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .admin-logout:hover {
            background: #fff5f5;
        }

        @media (max-width: 768px) {
            .admin-header-container {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .admin-header-left {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
            }

            .admin-nav {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 0.5rem;
            }

            .admin-nav a span {
                display: none;
            }

            .admin-header-right {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>

    <div class="max-w-7xl mx-auto px-4">
        <!-- Tabs de Navegación -->
        <div class="mb-8 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button 
                    class="tab-btn border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm active" 
                    data-tab="citas">
                    Gestión de Citas
                </button>
                <button 
                    class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" 
                    data-tab="servicios">
                    Gestión de Servicios
                </button>
                <button 
                    class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" 
                    data-tab="usuarios">
                    Gestión de Usuarios
                </button>
                <button 
                    class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" 
                    data-tab="estadisticas">
                    Análisis y Estadísticas
                </button>
            </nav>
        </div>

        <!-- Contenido de las Tabs -->
        <div id="tab-contents">
            <!-- Tab Citas -->
            <div class="tab-content" id="citas-tab">
                <?php include __DIR__ . '/citas.php'; ?>
            </div>

            <!-- Tab Servicios -->
            <div class="tab-content hidden" id="servicios-tab">
                <?php include __DIR__ . '/servicios.php'; ?>
            </div>

            <!-- Tab Usuarios -->
            <div class="tab-content hidden" id="usuarios-tab">
                <?php include __DIR__ . '/usuarios.php'; ?>
            </div>

            <!-- Tab Estadísticas -->
            <div class="tab-content hidden" id="estadisticas-tab">
                <?php include __DIR__ . '/estadisticas.php'; ?>
            </div>
        </div>
    </div>
</div>
