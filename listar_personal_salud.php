<?php
session_start();
require 'conexion.php';
include 'includes/header.php';

$sql = "SELECT * FROM personal_salud ORDER BY personal_id DESC";
$stmt = $pdo->query($sql);
$personal = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body style="background: linear-gradient(135deg, #e8f5e9 60%, #b2dfdb 100%); min-height:100vh;">
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="flex-grow-1 d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <div class="card p-4 shadow-lg border-0 w-100" style="max-width:900px; border-radius: 20px;">
            <div class="d-flex align-items-center mb-3">
                <div class="icon-circle-list me-2">
                    <i class="bi bi-person-badge"></i>
                </div>
                <h4 class="fw-bold mb-0" style="color:#256029;letter-spacing:1px;">Personal de Salud Registrado</h4>
            </div>
            <table class="table table-bordered table-striped bg-white mt-3" style="border-radius:12px;overflow:hidden;">
                <thead style="background:#256029;color:#fff;">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Cargo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($personal as $p): ?>
                        <tr>
                            <td><?= $p['personal_id'] ?></td>
                            <td><?= htmlspecialchars($p['nombre']) ?></td>
                            <td><?= htmlspecialchars($p['cedula']) ?></td>
                            <td><?= htmlspecialchars($p['cargo']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
</style>
</body>
</html>
