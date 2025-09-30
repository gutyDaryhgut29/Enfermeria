<?php
session_start();
if (!isset($_SESSION['nombre_usuario'])) {
    header('Location: iniciar_sesion.php');
    exit;
}
?>
<?php require 'conexion.php'; ?>
<?php include 'includes/header.php'; ?>
<?php if (isset($_GET['ok']) && $_GET['ok'] == 1): ?>
<div class="alert alert-success text-center" style="position:fixed; top:80px; left:50%; transform:translateX(-50%); z-index:2000; min-width:300px; max-width:90vw;">
    ¡Registro realizado correctamente!
</div>
<?php endif; ?>
<div style="width:100vw; min-height:100vh; background: none;">
    <?php include 'includes/sidebar.php'; ?>
    <div class="flex-grow-1" style="padding-left: 150px; padding-top: 0px; box-sizing: border-box; min-height:100vh;">
        <div class="container-fluid py-4" style="padding-top: 0.2rem !important;">
            <div class="row g-4 justify-content-center align-items-stretch" style="justify-content: center !important;">
                <div class="col-12 mb-2">
                    <div class="d-flex align-items-center gap-3">
                    </div>
                </div>
                <!-- Tarjeta: Pacientes -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card card-glass-dashboard h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="icon-circle-glass-lg mb-3">
                                    <i class="bi bi-person-vcard"></i>
                                </div>
                                <h4 class="fw-bold mb-2 title-glass">Gestión de Pacientes</h4>
                            </div>
                            <div class="d-flex flex-column gap-2 mt-2">
                                <a href="registrar_paciente.php" class="btn btn-gradient-glass btn-lg w-100"><i class="bi bi-person-plus"></i> Registrar</a>
                                <a href="listar_pacientes.php" class="btn btn-outline-glass btn-lg w-100"><i class="bi bi-people"></i> Ver Pacientes</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta: Consultas -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card card-glass-dashboard h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="icon-circle-glass-lg mb-3">
                                    <i class="bi bi-journal-medical"></i>
                                </div>
                                <h4 class="fw-bold mb-2 title-glass">Consultas Médicas</h4>
                            </div>
                            <div class="d-flex flex-column gap-2 mt-2">
                                <a href="registrar_consulta.php" class="btn btn-gradient-glass btn-lg w-100"><i class="bi bi-journal-plus"></i> Registrar</a>
                                <a href="listar_consultas.php" class="btn btn-outline-glass btn-lg w-100"><i class="bi bi-journal-text"></i> Ver Consultas</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta: Usuarios -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card card-glass-dashboard h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="icon-circle-glass-lg mb-3">
                                    <i class="bi bi-person-lines-fill"></i>
                                </div>
                                <h4 class="fw-bold mb-2 title-glass">Usuarios</h4>
                            </div>
                            <div class="d-flex flex-column gap-2 mt-2">
                                <a href="registrar_usuario.php" class="btn btn-gradient-glass btn-lg w-100"><i class="bi bi-person-plus"></i> Registrar</a>
                                <a href="listar_usuarios.php" class="btn btn-outline-glass btn-lg w-100"><i class="bi bi-people"></i> Ver Usuarios</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta: Buscador de Pacientes (grande, ocupa ancho) -->
                <div class="col-12 col-xl-9">
                    <div class="card card-glass-dashboard h-auto text-center p-0">
                        <div class="card-body py-3 px-2">
                            <form method="get" action="listar_pacientes.php" class="row g-2 justify-content-center align-items-center mb-2">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <input type="text" name="cedula" class="form-control input-glass input-lg" placeholder="Buscar paciente por cédula..." required>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-gradient-glass btn-lg"><i class="bi bi-search"></i> Buscar</button>
                                </div>
                            </form>
                            <div class="text-muted small mb-2">Busca pacientes por cédula para ver su expediente.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
html, body {
    min-height: 100vh;
    height: 100%;
    width: 100vw;
    background: linear-gradient(120deg, #e8f5e9 0%, #a8e063 60%, #43a047 100%) !important;
    background-attachment: fixed;
    background-size: cover;
    background-repeat: no-repeat;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}
body, html {
    background: none !important;
}
.icon-glass-lg {
    background: rgba(67,160,71,0.13);
    border-radius: 16px;
    box-shadow: 0 2px 12px 0 #43a04722;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.6rem;
    color: #43a047;
    transition: box-shadow 0.2s, transform 0.2s;
}
.icon-glass-lg:hover {
    box-shadow: 0 0 0 4px #b2dfdb, 0 4px 20px rgba(67,160,71,0.13);
    transform: scale(1.08);
}
.title-glass {
    color: #256029;
    letter-spacing: 1px;
    text-shadow: 0 1px 0 #fff, 0 2px 8px #b2dfdb44;
}
.card-glass-dashboard {
    background: rgba(255,255,255,0.92);
    border-radius: 22px;
    box-shadow: 0 4px 32px 0 #43a04722;
    backdrop-filter: blur(6px);
    border: 1.5px solid #e0e0e0;
    transition: box-shadow 0.2s, transform 0.2s;
    min-height: 150px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0;
}
.card-glass-dashboard .card-body {
    padding: 1.2rem 1.5rem 0.7rem 1.5rem;
}
.card-glass-dashboard:hover {
    box-shadow: 0 0 0 4px #b2dfdb, 0 8px 32px rgba(67,160,71,0.13);
    transform: scale(1.02);
}
.icon-circle-glass-lg {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e8f5e9 60%, #b2dfdb 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #43a047;
    box-shadow: 0 2px 12px 0 #43a04722;
    margin: 0 auto;
    transition: box-shadow 0.2s, transform 0.2s;
}
.icon-circle-glass-lg i {
    color: #43a047;
}
.btn-gradient-glass {
    background: linear-gradient(90deg, #43a047 60%, #a8e063 100%);
    color: #fff !important;
    border: none;
    border-radius: 1.2rem;
    font-weight: 500;
    box-shadow: 0 2px 8px 0 #43a04722;
    transition: background 0.18s, color 0.18s, box-shadow 0.18s, transform 0.18s;
}
.btn-gradient-glass:hover {
    background: linear-gradient(90deg, #388e3c 60%, #43a047 100%);
    color: #fff !important;
    box-shadow: 0 8px 32px 0 #43a04744;
    transform: scale(1.06);
}
.btn-outline-glass {
    background: #fff;
    color: #43a047 !important;
    border: 2px solid #43a047;
    border-radius: 1.2rem;
    font-weight: 500;
    box-shadow: 0 2px 8px 0 #43a04722;
    transition: background 0.18s, color 0.18s, box-shadow 0.18s, border 0.18s, transform 0.18s;
}
.btn-outline-glass:hover {
    background: #43a047;
    color: #fff !important;
    border: 2px solid #388e3c;
    box-shadow: 0 8px 32px 0 #43a04744;
    transform: scale(1.06);
}
.input-glass.input-lg {
    background: rgba(255,255,255,0.7);
    border-radius: 1.2rem;
    border: 1.5px solid #b2dfdb;
    box-shadow: 0 1px 4px #43a04711;
    font-size: 1.15rem;
    padding: 0.85rem 1.2rem;
    transition: border 0.18s, box-shadow 0.18s;
}
.input-glass.input-lg:focus {
    border: 1.5px solid #43a047;
    box-shadow: 0 2px 8px #43a04722;
}
.icon-glass-lg.icon-glass-md {
    width: 58px;
    height: 58px;
    font-size: 2rem;
}
.title-glass.title-md {
    font-size: 1.55rem;
}
@media (max-width: 991.98px) {
    .container-fluid.py-4 {
        padding: 1.2rem !important;
    }
    .card-glass-dashboard {
        border-radius: 16px;
        min-height: 120px;
        padding: 0;
    }
    .card-glass-dashboard .card-body {
        padding: 0.8rem 0.7rem 0.5rem 0.7rem;
    }
    .icon-circle-glass-lg, .icon-glass-lg {
        width: 54px;
        height: 54px;
        font-size: 1.7rem;
    }
    .icon-glass-lg.icon-glass-md {
        width: 42px;
        height: 42px;
        font-size: 1.25rem;
    }
    .title-glass.title-md {
        font-size: 1.08rem;
    }
}
</style>
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<?php
// Si se busca por cédula, redirigir a expediente_paciente.php con el paciente_id correspondiente
if (isset($_GET['cedula']) && $_GET['cedula'] !== '') {
    $cedula = trim($_GET['cedula']);
    $stmt = $pdo->prepare("SELECT paciente_id FROM paciente WHERE cedula = ?");
    $stmt->execute([$cedula]);
    if ($row = $stmt->fetch()) {
        header('Location: expediente_paciente.php?paciente_id=' . $row['paciente_id']);
        exit;
    } else {
        echo "<script>alert('No se encontró paciente con esa cédula');</script>";
    }
}
