<?php
session_start();
require 'conexion.php';
include 'includes/header.php';

$sql = "SELECT pr.procedimiento_id, p.nombre AS paciente, ps.nombre AS personal, 
               pr.procedimiento, pr.peso, pr.talla, pr.fecha_procedimiento, pr.observacion
        FROM procedimiento pr
        INNER JOIN paciente p ON pr.paciente_id = p.paciente_id
        INNER JOIN personal_salud ps ON pr.personal_id = ps.personal_id
        ORDER BY pr.procedimiento_id DESC";

$stmt = $pdo->query($sql);
$procedimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body style="background: linear-gradient(135deg, #e8f5e9 60%, #b2dfdb 100%); min-height:100vh;">
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-start" style="min-height:100vh;">
        <div class="d-flex align-items-center mb-3 mt-4 w-100 px-3" style="max-width:1100px;">
            <div class="icon-circle-list me-2">
                <i class="bi bi-clipboard2-pulse"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color:#256029;letter-spacing:1px;">Procedimientos Clínicos Registrados</h4>
        </div>
        <div class="w-100 px-2" style="max-width:1100px;">
            <div class="row justify-content-start m-0 w-100">
                <?php if (empty($procedimientos)): ?>
                    <div class="text-center text-muted">No se encontraron procedimientos.</div>
                <?php else: ?>
                    <?php foreach ($procedimientos as $row): ?>
                        <div class="col-12 col-md-8 col-lg-6">
                            <div class="card expediente-card mb-4 shadow-lg mx-auto border-0 procedimiento-hover" style="max-width: 540px; background: #fff; border: 2px solid #43a047; transition: box-shadow 0.2s, border-color 0.2s;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;">
                                            <i class="bi bi-clipboard2-pulse text-white" style="font-size:1.5rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-success text-truncate" style="font-size:1.15rem;max-width:220px;">Paciente: <?= htmlspecialchars($row['paciente']) ?></div>
                                            <div class="fw-semibold text-dark text-truncate" style="font-size:1.1rem;max-width:220px;">ID: <?= $row['procedimiento_id'] ?></div>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row g-2 mb-2">
                                        <div class="col-6"><span class="text-success fw-semibold">Personal Salud</span><br><span><?= htmlspecialchars($row['personal']) ?></span></div>
                                        <div class="col-6"><span class="text-success fw-semibold">Procedimiento</span><br><span><?= nl2br(htmlspecialchars($row['procedimiento'])) ?></span></div>
                                        <div class="col-6"><span class="text-success fw-semibold">Peso (kg)</span><br><span><?= $row['peso'] ?></span></div>
                                        <div class="col-6"><span class="text-success fw-semibold">Talla (m)</span><br><span><?= $row['talla'] ?></span></div>
                                        <div class="col-6"><span class="text-success fw-semibold">Fecha</span><br><span><?= $row['fecha_procedimiento'] ?></span></div>
                                        <div class="col-12"><span class="text-success fw-semibold">Observación</span><br><span><?= nl2br(htmlspecialchars($row['observacion'])) ?></span></div>
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
.icon-circle-list {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #a8e063;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #256029;
    box-shadow: 0 2px 8px rgba(67,160,71,0.10);
}
.card {
    border-radius: 20px !important;
}
th, td {
    vertical-align: middle !important;
}
.expediente-card {
    border-radius: 20px !important;
    background: #e0f7fa;
    box-shadow: 0 6px 32px rgba(44,62,80,0.10);
    min-height: 180px;
    border: none;
    transition: box-shadow 0.2s, border-color 0.2s;
}
.procedimiento-hover:hover {
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
