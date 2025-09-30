<!-- MENÚ LATERAL -->
<div class="sidebar-glass p-3" id="sidebarMenu">
    <ul class="nav flex-column gap-2">


        <!-- INICIO -->
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 py-2 px-3 sidebar-link" href="index.php">
                <i class="bi bi-house-door-fill"></i> <span>Inicio</span>
            </a>
        </li>

        <!-- PACIENTES -->
        <li class="nav-item mt-2">
            <small class="text-uppercase fw-semibold text-muted ps-3">Pacientes</small>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 py-2 px-3 sidebar-link" href="listar_pacientes.php">
                <i class="bi bi-people-fill"></i> <span>Lista</span>
            </a>
        </li>

        <!-- CONSULTAS -->
        <li class="nav-item mt-2">
            <small class="text-uppercase fw-semibold text-muted ps-3">Consultas</small>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 py-2 px-3 sidebar-link" href="listar_consultas.php">
                <i class="bi bi-journal-medical"></i> <span>Lista</span>
            </a>
        </li>

        <!-- USUARIOS -->
        <li class="nav-item mt-2">
            <small class="text-uppercase fw-semibold text-muted ps-3">Usuarios</small>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center gap-2 py-2 px-3 sidebar-link" href="listar_usuarios.php">
                <i class="bi bi-person-lines-fill"></i> <span>Lista</span>
            </a>
        </li>
    </ul>
</div>

<!-- ESTILOS -->
<style>
.sidebar-glass {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(10px);
    border-right: 1px solid rgba(0, 0, 0, 0.05);
    width: 150px;
    min-width: 150px;
    min-height: 100vh;
    border-radius: 0 18px 18px 0;
    box-shadow: 5px 0 15px rgba(0, 0, 0, 0.08);
    position: fixed;
    top: 64px; /* Altura del header */
    left: 0;
    z-index: 1000;
    transition: left 0.3s ease;
}

.sidebar-link {
    font-size: 1.05rem;
    font-weight: 500;
    color: #256029 !important;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.sidebar-link:hover, .sidebar-link.active {
    background: linear-gradient(90deg, #d0f0c0 0%, #b2dfdb 100%);
    color: #1b5e20 !important;
    transform: scale(1.03);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    text-decoration: none;
}

.sidebar-link i {
    font-size: 1.3rem;
    color: #43a047;
    transition: transform 0.2s;
}

.sidebar-link:hover i {
    transform: scale(1.2);
    filter: drop-shadow(0 0 2px #81c784);
}

/* Responsive: el menú lateral siempre visible, sin espacio arriba */
@media (max-width: 991.98px) {
    .sidebar-glass {
        width: 140px;
        min-width: 120px;
        top: 56px; /* Ajusta si tu header es más pequeño en móvil */
        height: calc(100vh - 56px);
    }
    .sidebar-toggle {
        display: none;
    }
}

@media (min-width: 992px) {
    .sidebar-toggle {
        display: none;
    }
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</script>
