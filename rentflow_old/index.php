<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentFlow - Sistema de Gestión de Alquileres</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        .nav-link {
            color: rgba(255,255,255,.75);
        }
        .nav-link:hover {
            color: rgba(255,255,255,1);
        }
        .nav-link.active {
            color: white !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">RentFlow</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-page="dashboard">
                            <i class="fas fa-tachometer-alt"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="propiedades">
                            <i class="fas fa-home"></i> Propiedades
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="inquilinos">
                            <i class="fas fa-users"></i> Inquilinos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="contratos">
                            <i class="fas fa-file-contract"></i> Contratos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="pagos">
                            <i class="fas fa-money-bill-wave"></i> Pagos
                        </a>
                    </li>
                </ul>
                <form class="d-flex ms-auto" role="search">
                    <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" />
                    <button class="btn btn-outline-light" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </nav>

    <div id="main-content" class="container-fluid mt-4">
        <!-- El contenido se cargará aquí dinámicamente -->
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    <script>
    // --- SPA Navegación con hash en la URL ---
    // Llama a cargarModulo y actualiza el hash al hacer clic en los links de menú
    function navegarModulo(modulo) {
        window.location.hash = '#' + modulo;
        if (typeof cargarModulo === 'function') {
            cargarModulo(modulo);
        }
    }

    // Al cargar la página, si hay hash, cargar el módulo correspondiente
    window.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash) {
            const modulo = window.location.hash.replace('#', '');
            if (modulo) navegarModulo(modulo);
        }
    });

    // Al cambiar el hash (navegación con atrás/adelante), cargar el módulo
    window.addEventListener('hashchange', function() {
        if (window.location.hash) {
            const modulo = window.location.hash.replace('#', '');
            if (modulo) navegarModulo(modulo);
        }
    });
    </script>
</body>
</html> 