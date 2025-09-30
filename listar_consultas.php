<?php
session_start();
require 'conexion.php';
include 'includes/header.php';
$sql = "SELECT c.consulta_id, p.nombre AS paciente, c.fecha_consulta, c.motivo, c.recomendaciones, c.intervencion_enfermeria
        FROM consulta c
        INNER JOIN paciente p ON c.paciente_id = p.paciente_id
        ORDER BY c.consulta_id DESC";
$stmt = $pdo->query($sql);
$consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body style="background: linear-gradient(135deg, #e8f5e9 60%, rgb(199, 231, 232) 100%); min-height:100vh; margin:0; padding:0;">
<div style="width:100vw; min-height:100vh; background: none;">
    <?php include 'includes/sidebar.php'; ?>
    <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-start"
         style="min-height:100vh; width:100vw; max-width:100vw; padding-left: 150px; padding-top: 64px; box-sizing: border-box;">
        <div class="d-flex align-items-center mb-3 mt-4 w-100 px-3" style="max-width:100vw;">
            <div class="icon-circle-list me-2">
                <i class="bi bi-journal-medical"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color:#256029;letter-spacing:1px;">Lista de Consultas</h4>
        </div>
        <div class="container-fluid py-4" style="max-width:100vw;">
            <div class="table-responsive rounded-4 shadow-sm" style="max-width:100vw; overflow-x:auto;">
                <table class="table table-hover align-middle mb-0" style="background:#fff; min-width:700px; width:100%; max-width:100vw;">
                    <thead class="table-success text-center align-middle">
                        <tr>
                            <th>Paciente</th>
                            <th class="col-fecha">Fecha</th>
                            <th>Motivo</th>
                            <th>Recomendaciones</th>
                            <th>Intervención</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($consultas)): ?>
                            <tr><td colspan="5" class="text-center text-muted">No se encontraron consultas.</td></tr>
                        <?php else: ?>
                            <?php foreach ($consultas as $row): ?>
                                <tr>
                                    <td> <?= htmlspecialchars($row['paciente']) ?> </td>
                                    <td class="text-center col-fecha"> <?= htmlspecialchars($row['fecha_consulta']) ?> </td>
                                    <td> <?= nl2br(htmlspecialchars($row['motivo'])) ?> </td>
                                    <td> <?= nl2br(htmlspecialchars($row['recomendaciones'])) ?> </td>
                                    <td> <?= nl2br(htmlspecialchars($row['intervencion_enfermeria'])) ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
    .col-fecha { min-width: 110px; text-align: center; }
    td, th { vertical-align: middle !important; }
    .icon-circle-list {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #b2dfdb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #256029;
        box-shadow: 0 2px 8px rgba(67,160,71,0.10);
    }
    @media (max-width: 991.98px) {
        .table-responsive { font-size: 0.93rem; }
        .btn-sm { font-size: 0.85rem; }
    }
</style>
</body>
</html>
