<?php
session_start();
require 'conexion.php';
include 'includes/header.php';
$sql = "SELECT ie.embarazo_id, p.nombre AS paciente, ie.ha_estado_embarazada, 
               ie.cant_embarazos, ie.cant_partos, ie.cesarea, ie.cant_abortos
        FROM inf_embarazo ie
        INNER JOIN paciente p ON ie.paciente_id = p.paciente_id
        ORDER BY ie.embarazo_id DESC";
$stmt = $pdo->query($sql);
$embarazos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body style="background: linear-gradient(135deg, #e8f5e9 60%, #b2dfdb 100%); min-height:100vh;">
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-start" style="min-height:100vh;">
        <div class="text-center mb-3 mt-4 w-100 px-3" style="max-width:950px;">
            <div class="icon-circle mb-2 mx-auto">
                <i class="bi bi-clipboard-heart"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color:#256029;letter-spacing:1px;">Información de Embarazo Registrada</h4>
        </div>
        <div class="w-100 px-2" style="max-width:950px;">
            <div class="row justify-content-start m-0 w-100">
                <?php if (empty($embarazos)): ?>
                    <div class="text-center text-muted">No se encontró información de embarazo.</div>
                <?php else: ?>
                    <?php foreach ($embarazos as $row): ?>
                        <div class="col-12 col-md-8 col-lg-6">
                            <div class="card expediente-card mb-4 shadow-lg mx-auto border-0 embarazo-hover" style="max-width: 480px; background: #fff; border: 2px solid #43a047; transition: box-shadow 0.2s, border-color 0.2s;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;">
                                            <i class="bi bi-clipboard-heart text-white" style="font-size:1.5rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-success text-truncate" style="font-size:1.15rem;max-width:220px;">Paciente: <?= htmlspecialchars($row['paciente']) ?></div>
                                            <div class="fw-semibold text-dark text-truncate" style="font-size:1.1rem;max-width:220px;">ID: <?= $row['embarazo_id'] ?></div>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row g-2 mb-2">
                                        <div class="col-6"><span class="text-success fw-semibold">¿Ha estado embarazada?</span><br><span><?= $row['ha_estado_embarazada'] ?></span></div>
                                        <div class="col-6"><span class="text-success fw-semibold">Embarazos</span><br><span><?= $row['cant_embarazos'] ?></span></div>
                                        <div class="col-6"><span class="text-success fw-semibold">Partos</span><br><span><?= $row['cant_partos'] ?></span></div>
                                        <div class="col-6"><span class="text-success fw-semibold">Cesáreas</span><br><span><?= $row['cesarea'] ?></span></div>
                                        <div class="col-6"><span class="text-success fw-semibold">Abortos</span><br><span><?= $row['cant_abortos'] ?></span></div>
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
.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #a8e063;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
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
    min-height: 160px;
    border: none;
    transition: box-shadow 0.2s, border-color 0.2s;
}
.embarazo-hover:hover {
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
