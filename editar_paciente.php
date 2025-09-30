<?php
require 'conexion.php';
session_start();
if (!isset($_SESSION['nombre_usuario'])) {
    header('Location: iniciar_sesion.php');
    exit;
}
include 'includes/header.php';
?>

<body style="background: linear-gradient(135deg, #e8f5e9 60%, #b2dfdb 100%) !important; min-height: 100vh;">
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-grow-1 p-3 p-md-4">
        <div style="max-width: 1000px; margin: auto;">
            <div class="text-center mb-4">
                <div class="icon-circle-login mb-2 mx-auto">
                    <i class="bi bi-person-vcard" style="font-size:2.5rem;"></i>
                </div>
                <h3 class="fw-bold mb-0" style="color:#256029;letter-spacing:1px;">
                    Editar Expediente Completo
                </h3>
            </div>

            <!-- Navegación de pestañas -->
            <ul class="nav nav-tabs mb-4 flex-wrap" id="tabsPaciente" role="tablist" style="border-bottom: 2px solid #a8e063;">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab-registro" data-bs-toggle="tab" href="#registro" role="tab" aria-selected="true">
                        Datos Personales
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-antecedente-familiar" data-bs-toggle="tab" href="#antecedente-familiar" role="tab" aria-selected="false">
                        Antecedente Familiar
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-antecedente-quirurgico" data-bs-toggle="tab" href="#antecedente-quirurgico" role="tab" aria-selected="false">
                        Antecedente Quirúrgico
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-enfermedad-personal" data-bs-toggle="tab" href="#enfermedad-personal" role="tab" aria-selected="false">
                        Enfermedad Personal
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-contacto-emergencia" data-bs-toggle="tab" href="#contacto-emergencia" role="tab" aria-selected="false">
                        Contacto Emergencia
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-procedimiento" data-bs-toggle="tab" href="#procedimiento" role="tab" aria-selected="false">
                        Procedimiento
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-consulta" data-bs-toggle="tab" href="#consulta" role="tab" aria-selected="false">
                        Consulta Médica
                    </a>
                </li>
            </ul>

            <!-- Contenido de pestañas -->
            <div class="tab-content" id="tabsPacienteContent">
                <div class="tab-pane fade show active" id="registro" role="tabpanel">
                    <?php include 'form_registro_paciente_simple.php'; ?>
                </div>
                <div class="tab-pane fade" id="antecedente-familiar" role="tabpanel">
                    <?php include 'form_antecedente_familiar_simple.php'; ?>
                </div>
                <div class="tab-pane fade" id="antecedente-quirurgico" role="tabpanel">
                    <?php include 'form_antecedente_quirurgico_simple.php'; ?>
                </div>
                <div class="tab-pane fade" id="enfermedad-personal" role="tabpanel">
                    <?php include 'form_enfermedad_personal_simple.php'; ?>
                </div>
                <div class="tab-pane fade" id="contacto-emergencia" role="tabpanel">
                    <?php include 'form_contacto_emergencia_simple.php'; ?>
                </div>
                <div class="tab-pane fade" id="procedimiento" role="tabpanel">
                    <?php include 'form_procedimiento_simple.php'; ?>
                </div>
                <div class="tab-pane fade" id="consulta" role="tabpanel">
                    <?php include 'form_consulta_simple.php'; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Recursos -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
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
/* Colores para los labels y botones de formularios dentro de las pestañas */
form label.form-label {
    color: #256029 !important;
    font-weight: 400 !important;
}
.btn-success, .btn-success:focus, .btn-success:active {
    background: #56ab2f !important;
    border-color: #56ab2f !important;
    color: #fff !important;
}
.form-select:focus, .form-control:focus {
    border-color: #56ab2f !important;
    box-shadow: 0 0 0 0.15rem #a8e06340 !important;
}
</style>
</body>
</html>
