<?php
session_start();
if (!isset($_SESSION['nombre_usuario'])) {
    header('Location: iniciar_sesion.php');
    exit;
}
require 'conexion.php';
include 'includes/header.php';

// Búsqueda por cédula
$cedula = isset($_GET['cedula']) ? trim($_GET['cedula']) : '';
$pacientes = [];
if ($cedula !== '') {
    $stmt = $pdo->prepare("SELECT * FROM paciente WHERE cedula = ?");
    $stmt->execute([$cedula]);
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT * FROM paciente ORDER BY paciente_id DESC");
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<body style="background: linear-gradient(135deg, #e8f5e9 60%, rgb(199, 231, 232) 100%); min-height:100vh; margin:0; padding:0;">
<div style="width:100vw; min-height:100vh; background: none;">
    <?php include 'includes/sidebar.php'; ?>
    <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-start"
         style="min-height:100vh; width:100vw; max-width:100vw; padding-left: 150px; padding-top: 64px; box-sizing: border-box;">
        <div class="d-flex align-items-center mb-3 mt-4 w-100 px-3" style="max-width:100vw;">
            <div class="icon-circle-list me-2">
                <i class="bi bi-person-vcard"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color:#256029;letter-spacing:1px;">Lista de Pacientes</h4>
        </div>

        <div class="container-fluid py-4" style="max-width:100vw;">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
                <form class="mb-0" method="get" autocomplete="off">
                    <div class="input-group">
                        <input type="text" name="cedula" class="form-control border-success" style="min-width:220px;max-width:300px;" placeholder="Buscar por Cédula" value="<?= htmlspecialchars($cedula) ?>" autofocus>
                        <button class="btn btn-success d-flex align-items-center gap-1" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <a href="registrar_paciente.php" class="btn btn-success d-flex align-items-center gap-1 fw-bold"><i class="bi bi-person-plus"></i> Agregar</a>
            </div>

            <div class="table-responsive rounded-4 shadow-sm" style="max-width:100vw; overflow-x:auto;">
                <table class="table table-hover align-middle mb-0" style="background:#fff; min-width:700px; width:100%; max-width:100vw;">
                    <thead class="table-success text-center align-middle">
                        <tr>
                            <th class="col-nombre">Nombre</th>
                            <th class="col-cedula">Cédula</th>
                            <th class="col-nacim">Nacimiento</th>
                            <th class="col-sexo">Sexo</th>
                            <th class="col-direccion">Dirección</th>
                            <th class="col-telefono">Teléfono</th>
                           <th class="col-opciones">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pacientes as $row): ?>
                        <tr>
                            <td class="col-nombre"><?= htmlspecialchars($row['nombre']) ?></td>
                            <td class="text-center col-cedula"><?= htmlspecialchars($row['cedula']) ?></td>
                            <td class="text-center col-nacim"><?= htmlspecialchars($row['fecha_nacimiento'] ?? '') ?></td>
                            <td class="text-center col-sexo"><?= htmlspecialchars($row['sexo'] ?? '') ?></td>
                            <td class="col-direccion"><?= htmlspecialchars($row['direccion'] ?? '') ?></td>
                            <td class="col-telefono"><?= htmlspecialchars($row['telefono'] ?? '') ?></td>
                            <td class="text-center col-opciones">
                                <a href="expediente_paciente.php?paciente_id=<?= $row['paciente_id'] ?>" class="btn btn-outline-primary btn-sm me-1" title="Ver expediente"><i class="bi bi-file-earmark-person"></i></a>
                                <a href="editar_paciente.php?id=<?= $row['paciente_id'] ?>" class="btn btn-outline-warning btn-sm" title="Editar paciente"><i class="bi bi-pencil-square"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table-responsive { border-radius: 18px; overflow-x: auto; overflow-y: visible; max-width: 100vw; }
    .table { font-size: 1.01rem; }
    .table thead th {
        font-weight: 600;
        letter-spacing: 0.5px;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
        white-space: nowrap;
    }
    .table td, .table th {
        padding-top: 0.65rem;
        padding-bottom: 0.65rem;
        padding-left: 0.85rem;
        padding-right: 0.85rem;
    }
    .btn-sm { font-size: 0.95rem; padding: 0.25rem 0.7rem; }

    .col-nombre     { min-width: 200px; white-space: nowrap; }
    .col-cedula     { min-width: 120px; text-align: center; }
    .col-nacim      { min-width: 110px; text-align: center; }
    .col-sexo       { min-width: 70px;  text-align: center; }
    .col-direccion  { min-width: 160px; max-width: 300px; }
    .col-telefono   { min-width: 100px; }
    .col-opciones   {
        min-width: 120px;
        text-align: center;
        position: sticky;
        right: 0;
        background: #fff;
        z-index: 2;
    }

    @media (max-width: 991.98px) {
        .table-responsive { font-size: 0.93rem; }
        .btn-sm { font-size: 0.85rem; }
    }
</style>
</body>
</html>