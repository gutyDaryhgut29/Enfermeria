<?php
session_start();
require 'conexion.php';
include 'includes/header.php';

// Obtener antecedentes quirúrgicos con el nombre del paciente
$sql = "SELECT aq.antecedente_id, p.nombre AS paciente, aq.cirugia
        FROM antecedente_quirurgico aq
        INNER JOIN paciente p ON aq.paciente_id = p.paciente_id
        ORDER BY aq.antecedente_id DESC";

$stmt = $pdo->query($sql);
$antecedentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body style="background: linear-gradient(135deg, #e8f5e9 60%, #b2dfdb 100%); min-height:100vh;">
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-start" style="min-height:100vh;">
        <div class="d-flex align-items-center mb-3 mt-4 w-100 px-3" style="max-width:900px;">
            <div class="icon-circle-list me-2">
                <i class="bi bi-hospital"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color:#256029;letter-spacing:1px;">Antecedentes Quirúrgicos</h4>
        </div>
        <div class="w-100 px-2" style="max-width:900px;">
            <div class="row justify-content-start m-0 w-100">
                <?php if (empty($antecedentes)): ?>
                    <div class="text-center text-muted">No se encontraron antecedentes quirúrgicos.</div>
                <?php else: ?>
                    <?php foreach ($antecedentes as $row): ?>
                        <div class="col-12 col-md-8 col-lg-6">
                            <div class="card expediente-card mb-4 shadow-lg mx-auto border-0 quirurgico-hover" style="max-width: 480px; background: #fff; border: 2px solid #43a047; transition: box-shadow 0.2s, border-color 0.2s;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;">
                                            <i class="bi bi-hospital text-white" style="font-size:1.5rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-success text-truncate" style="font-size:1.15rem;max-width:220px;">Paciente: <?= htmlspecialchars($row['paciente']) ?></div>
                                            <div class="fw-semibold text-dark text-truncate" style="font-size:1.1rem;max-width:220px;">ID: <?= $row['antecedente_id'] ?></div>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row g-2 mb-2">
                                        <div class="col-12"><span class="text-success fw-semibold">Cirugía</span><br><span><?= htmlspecialchars($row['cirugia']) ?></span></div>
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
<style>
.expediente-card {
    border-radius: 20px !important;
    background: #e0f7fa;
    box-shadow: 0 6px 32px rgba(44,62,80,0.10);
    min-height: 140px;
    border: none;
    transition: box-shadow 0.2s, border-color 0.2s;
}
.quirurgico-hover:hover {
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
