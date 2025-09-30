<?php
session_start();
require 'conexion.php';
include 'includes/header.php';

// Búsqueda por cédula
$cedula = isset($_GET['cedula']) ? trim($_GET['cedula']) : '';
$usuarios = [];
if ($cedula !== '') {
    $stmt = $pdo->prepare("SELECT nombre, cedula, cargo FROM usuario WHERE cedula = ?");
    $stmt->execute([$cedula]);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT nombre, cedula, cargo FROM usuario ORDER BY usuario_id DESC");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<body style="background: linear-gradient(135deg, #e8f5e9 60%, #b2dfdb 100%); min-height:100vh;">

<!-- Navbar superior con botón hamburguesa -->
<nav class="navbar navbar-expand-lg navbar-light bg-success w-100 px-3">
    <button class="btn btn-light d-lg-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
        <i class="bi bi-list" style="font-size:1.5rem;"></i>
    </button>
    <span class="navbar-brand text-white fw-bold">SisEnfermería</span>
</nav>

<div class="d-flex">
    <!-- Sidebar como offcanvas en móviles -->
    <div class="offcanvas offcanvas-start bg-white shadow-lg" tabindex="-1" id="sidebar">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title text-success">Menú</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <?php include 'includes/sidebar.php'; ?>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-start px-2 px-md-4" style="min-height:100vh;">
        
        <!-- Título -->
        <div class="d-flex align-items-center mb-3 mt-4 w-100">
            <div class="icon-circle-list me-2">
                <i class="bi bi-people"></i>
            </div>
            <h4 class="fw-bold mb-0 text-success" style="letter-spacing:1px;">Lista de Usuarios</h4>
        </div>

        <!-- Buscador -->
        <form class="mb-4 w-100" method="get" autocomplete="off">
            <div class="input-group w-100">
                <input type="text" name="cedula" class="form-control" placeholder="Buscar por cédula..." value="<?= htmlspecialchars($cedula) ?>" autofocus>
                <button class="btn btn-success" type="submit"><i class="bi bi-search"></i> Buscar</button>
                <?php if ($cedula !== ''): ?>
                    <a href="listar_usuarios.php" class="btn btn-outline-secondary">Ver todos</a>
                <?php endif; ?>
            </div>
        </form>

        <!-- Lista de usuarios -->
        <div class="w-100">
            <div class="row justify-content-start m-0">
                <?php if (empty($usuarios)): ?>
                    <div class="text-center text-muted">No se encontraron usuarios.</div>
                <?php else: ?>
                    <?php foreach ($usuarios as $row): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card expediente-card mb-4 shadow-lg border-0 usuario-hover">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;">
                                            <i class="bi bi-person-vcard text-white" style="font-size:1.5rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-success text-truncate" style="font-size:1.15rem;">
                                                <?= htmlspecialchars($row['nombre']) ?>
                                            </div>
                                            <div class="fw-semibold text-dark text-truncate" style="font-size:1.1rem;">
                                                Cédula: <?= htmlspecialchars($row['cedula']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div>
                                        <span class="text-success fw-semibold">Cargo</span><br>
                                        <span><?= htmlspecialchars($row['cargo']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
.icon-circle-list {
    width: 44px; height: 44px;
    border-radius: 50%; background: #a8e063;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: #256029;
    box-shadow: 0 2px 8px rgba(67,160,71,0.10);
}
.card { border-radius: 20px !important; }
.expediente-card {
    border-radius: 20px !important;
    background: #e0f7fa;
    box-shadow: 0 6px 32px rgba(44,62,80,0.10);
    min-height: 180px; border: none;
    transition: box-shadow 0.2s, border-color 0.2s;
}
.usuario-hover:hover {
    box-shadow: 0 8px 36px 0 #43a04744;
    border-color: #256029 !important;
}
@media (max-width: 768px) {
    .expediente-card { padding: 0.5rem !important; }
    .card-body { padding: 1rem !important; }
    .expediente-card .fw-bold, .expediente-card .fw-semibold { font-size:1rem !important; }
}
</style>
</body>
</html>
