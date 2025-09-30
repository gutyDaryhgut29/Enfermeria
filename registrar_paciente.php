<?php include 'includes/header.php'; ?>
<body style="background: linear-gradient(135deg, #e8f5e9 60%, #b2dfdb 100%); min-height:100vh;">
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <main class="flex-grow-1 p-3 p-md-4">
        <div style="max-width: 1000px; margin: auto;">
            <div class="text-center mb-4">
                <div class="icon-circle-login mb-2 mx-auto">
                    <i class="bi bi-person-vcard" style="font-size:2.5rem;"></i>
                </div>
                <h3 class="fw-bold mb-0" style="color:#256029;letter-spacing:1px;">Registrar Paciente</h3>
            </div>

            <!-- Pestañas de navegación -->
            <ul class="nav nav-tabs mb-4 flex-wrap" id="tabsPaciente" role="tablist" style="border-bottom: 2px solid #a8e063;">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-registro" data-bs-toggle="tab" href="#registro" role="tab">Registrar Paciente</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-antecedente-familiar" data-bs-toggle="tab" href="#antecedente-familiar" role="tab">Antecedente Familiar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-antecedente-quirurgico" data-bs-toggle="tab" href="#antecedente-quirurgico" role="tab">Antecedente Quirúrgico</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-enfermedad-personal" data-bs-toggle="tab" href="#enfermedad-personal" role="tab">Enfermedad Personal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-procedimiento" data-bs-toggle="tab" href="#procedimiento" role="tab">Procedimientos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-contacto-emergencia" data-bs-toggle="tab" href="#contacto-emergencia" role="tab">Contacto Emergencia</a>
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
                <div class="tab-pane fade" id="procedimiento" role="tabpanel">
                    <?php include 'form_procedimiento_simple.php'; ?>
                </div>
                <div class="tab-pane fade" id="contacto-emergencia" role="tabpanel">
                    <?php include 'form_contacto_emergencia_simple.php'; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- ESTILOS -->
<style>
.icon-circle-login {
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
}
.nav-tabs .nav-link.active {
    border-bottom: 2.5px solid #388e3c !important;
    color: #388e3c !important;
}
</style>

<!-- JS para cambio de pestaña al registrar -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const formPaciente = document.getElementById('formRegistroPaciente') || document.getElementById('form-paciente');

    if (formPaciente) {
        formPaciente.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(formPaciente);
            fetch('guardar_paciente.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                const respuesta = data.trim();
                if (respuesta === 'duplicado') {
                    alert('La cédula ya existe. Por favor, ingrese una diferente.');
                } else if (respuesta === 'ok') {
                    alert('Paciente registrado exitosamente');
                    const tab = new bootstrap.Tab(document.querySelector('#tab-antecedente-familiar'));
                    tab.show();
                } else {
                    alert('Error al registrar el paciente. Intente nuevamente.');
                }
            })
            .catch(error => {
                alert('Error en la solicitud: ' + error);
            });
        });
    }
});
</script>
</body>
</html>