<?php
session_start();
require 'conexion.php';
include 'includes/header.php';

$error = '';
$exito = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = trim($_POST['cedula']);
    $fecha_consulta = $_POST['fecha_consulta'];
    $motivo = $_POST['motivo'];
    $recomendaciones = $_POST['recomendaciones'];
    $intervencion = $_POST['intervencion_enfermeria'];

    // Buscar paciente por cédula
    $stmt = $pdo->prepare("SELECT paciente_id FROM paciente WHERE cedula = ?");
    $stmt->execute([$cedula]);
    $paciente = $stmt->fetch();
    if ($paciente) {
        $paciente_id = $paciente['paciente_id'];
        // Guardar consulta
        $sql = "INSERT INTO consulta (paciente_id, fecha_consulta, motivo, recomendaciones, intervencion_enfermeria) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$paciente_id, $fecha_consulta, $motivo, $recomendaciones, $intervencion]);
        $exito = true;
    } else {
        $error = 'No se encontró paciente con esa cédula.';
    }
}
?>
<style>
.bg-simple {
    min-height: 100vh;
    background: #f6f8fa;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card-clean {
    background: #fff;
    box-shadow: 0 4px 24px 0 rgba(44,62,80,0.10);
    border-radius: 18px;
    padding: 2.5rem 2.5rem 2rem 2.5rem;
    max-width: 900px;
    width: 100%;
    border: 1.5px solid #e0e0e0;
    position: relative;
    animation: fadeIn 0.7s;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.form-label {
    font-weight: 600;
    color: #2d572c;
    letter-spacing: 0.5px;
    margin-bottom: 0.35rem;
}
.input-group {
    margin-bottom: 1.1rem;
}
.input-group-text {
    background: #f0f4f8;
    border: none;
    color: #56ab2f;
    font-size: 1.15rem;
}
.form-control, .form-select {
    min-height: 48px;
    font-size: 1.08rem;
    border-radius: 10px;
    border: 1.2px solid #e0e0e0;
    background: #f9fafb;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-control:focus, .form-select:focus {
    border-color: #56ab2f;
    box-shadow: 0 0 0 2px #a8e06333;
    background: #fff;
}
#form-consulta .btn {
    background: linear-gradient(90deg,#43a047 60%,#a8e063 100%);
    color: #fff;
    border: none;
    border-radius: 1.2rem;
    font-weight: 500;
    box-shadow: 0 2px 8px 0 #43a04722;
    transition: background 0.18s, color 0.18s, box-shadow 0.18s, transform 0.18s;
    font-size: 1.15rem;
    letter-spacing: 0.5px;
    padding: 0.8rem 0;
}
#form-consulta .btn:hover {
    background: linear-gradient(90deg, #388e3c 60%, #43a047 100%);
    color: #fff;
    box-shadow: 0 8px 32px 0 #43a04744;
    transform: scale(1.04);
}
@media (max-width: 991.98px) {
    .card-clean { padding: 1.2rem 0.5rem; max-width: 98vw; }
    .row-cols-md-2 > .col { flex: 0 0 100%; max-width: 100%; }
}
</style>
<div class="bg-simple">
  <div class="card-clean">
    <div class="text-center mb-4">
      <div style="font-size:2.5rem;color:#56ab2f;"><i class="bi bi-journal-medical"></i></div>
      <h4 class="fw-bold mb-0" style="color:#256029;letter-spacing:1px;">Registrar Consulta Médica</h4>
      <div class="mt-3 mb-2 text-start">
        <a href="index.php" class="btn btn-outline-success fw-bold">
          &larr; Atrás
        </a>
      </div>
    </div>
    <?php if ($exito): ?>
      <div class="alert alert-success text-center py-2 mb-3">Consulta registrada correctamente.</div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert alert-danger text-center py-2 mb-3"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="" id="form-consulta" autocomplete="off">
      <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
            <input type="text" name="cedula" class="form-control" required placeholder="Cédula del paciente">
          </div>
        </div>
        <div class="col">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
            <input type="date" name="fecha_consulta" class="form-control" required>
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label">Motivo de la Consulta</label>
            <textarea name="motivo" class="form-control" rows="2" required></textarea>
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label">Recomendaciones</label>
            <textarea name="recomendaciones" class="form-control" rows="2"></textarea>
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label">Intervención de Enfermería</label>
            <textarea name="intervencion_enfermeria" class="form-control" rows="2"></textarea>
          </div>
        </div>
      </div>
      <button type="submit" class="btn w-100 fw-bold mt-2">Registrar Consulta</button>
    </form>
  </div>
</div>
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">