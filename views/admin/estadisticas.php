<h1 class="nombre-pagina">Dashboard de Estadísticas</h1>

<div class="dashboard-wrapper">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Panel de Control</h2>
            <span class="dashboard-badge">En vivo</span>
        </div>
        <iframe 
            title="Dashboard StyloReserva" 
            width="100%" 
            height="600" 
            src="https://app.powerbi.com/view?r=eyJrIjoiNTA1NTIyNzgtOTFkZS00NDFhLWFhZmMtNWE2ZjE0MzJiMDk5IiwidCI6IjM4YTFlMGExLWI2YjEtNDJlOS1iM2E5LTU5NzYyNjY3MGIxNyIsImMiOjR9" 
            frameborder="0" 
            allowFullScreen="true"
            class="dashboard-iframe">
        </iframe>
    </div>
</div>

<style>
    .dashboard-wrapper {
        padding: 2rem;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        min-height: calc(100vh - 100px);
    }

    .dashboard-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 2rem;
        border-radius: 1.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        max-width: 1300px;
        width: 95%;
        transform: translateY(0);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .dashboard-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .dashboard-header h2 {
        color: #2d3748;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    .dashboard-badge {
        background: linear-gradient(135deg, #00b09b, #96c93d);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 500;
        animation: pulse 2s infinite;
    }

    .dashboard-iframe {
        border-radius: 1rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .dashboard-iframe:hover {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(150, 201, 61, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(150, 201, 61, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(150, 201, 61, 0);
        }
    }

    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 1rem;
        }

        .dashboard-container {
            padding: 1rem;
        }
        
        .dashboard-iframe {
            height: 400px;
        }

        .dashboard-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }
</style>
