<?php
require 'conexion.php';
$consulta = isset($consulta) ? $consulta : null;
$paciente_id = isset($paciente_id) ? $paciente_id : ($consulta['paciente_id'] ?? '');
$stmt = $pdo->query("SELECT paciente_id, nombre, cedula FROM paciente ORDER BY nombre");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<form method="POST" action="guardar_consulta.php" class="row g-3 needs-validation" novalidate>
    <?php if (empty($paciente_id)): ?>
    <div class="col-md-6">
        <label class="form-label fw-semibold text-success">Cédula</label>
        <input type="text" name="cedula" class="form-control" placeholder="Ingrese la cédula del paciente" required>
    </div>
    <?php else: ?>
        <input type="hidden" name="paciente_id" value="<?= htmlspecialchars($paciente_id) ?>">
    <?php endif; ?>

    <div class="col-md-6">
        <label class="form-label fw-semibold text-success">Fecha de Consulta</label>
        <input type="date" name="fecha_consulta" class="form-control" required value="<?= isset($consulta['fecha_consulta']) ? htmlspecialchars($consulta['fecha_consulta']) : '' ?>">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold text-success">Motivo de la consulta</label>
        <textarea name="motivo" class="form-control" rows="2" required><?= isset($consulta['motivo']) ? htmlspecialchars($consulta['motivo']) : '' ?></textarea>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold text-success">Recomendaciones</label>
        <textarea name="recomendaciones" class="form-control" rows="2"><?= isset($consulta['recomendaciones']) ? htmlspecialchars($consulta['recomendaciones']) : '' ?></textarea>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold text-success">Intervención de Enfermería</label>
        <textarea name="intervencion_enfermeria" class="form-control" rows="2"><?= isset($consulta['intervencion_enfermeria']) ? htmlspecialchars($consulta['intervencion_enfermeria']) : '' ?></textarea>
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-success w-100 fw-bold" style="font-size:1.08rem; letter-spacing:0.5px;">
            Actualizar Consulta
        </button>
    </div>
</form>
<style>
    body {
        background: linear-gradient(135deg, #e8f5e9 60%, #b2dfdb 100%) !important;
        min-height: 100vh;
        font-weight: 400;
    }
<!-- Botón Atrás -->
<div class="mt-3 mb-2">
    <a href="index.php" class="btn btn-outline-success fw-bold" style="float:left;">
        &larr; Atrás
    </a>
</div>
    .icon-circle {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #a8e063;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #256029;
        box-shadow: 0 2px 8px rgba(67,160,71,0.10);
    }
    .nav-tabs .nav-link {
        color: #256029 !important;
        font-weight: 600;
        border: none !important;
        background: none !important;
        border-bottom: 2.5px solid transparent;
        margin-right: 8px;
        transition: all 0.3s ease;
    }
    .nav-tabs .nav-link.active {
        border-bottom: 2.5px solid #388e3c !important;
        color: #388e3c !important;
        background-color: transparent !important;
    }
    form label.form-label {
        color: #256029 !important;
        font-weight: 400 !important;
    }
    .btn-success,
    .btn-success:focus,
    .btn-success:active {
        background: #56ab2f !important;
        border-color: #56ab2f !important;
        color: #fff !important;
    }
    .form-select:focus,
    .form-control:focus {
        border-color: #56ab2f !important;
        box-shadow: 0 0 0 0.15rem #a8e06340 !important;
    }
    </style>
