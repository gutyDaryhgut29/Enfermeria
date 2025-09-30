<?php
require 'conexion.php';
$stmt = $pdo->query("SELECT paciente_id, nombre, cedula FROM paciente ORDER BY nombre");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<form method="POST" class="row g-3" id="form-procedimiento">
    <div class="col-md-6">
        <label class="form-label">Cédula</label>
        <input type="text" name="cedula" class="form-control" placeholder="Ingrese la cédula del paciente" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Procedimiento</label>
        <input type="text" name="procedimiento" class="form-control" required>
    </div>
     <div class="col-md-6">
        <label class="form-label">Peso</label>
        <input type="text" name="peso" class="form-control" required>
    </div>
     <div class="col-md-6">
        <label class="form-label">Talla</label>
        <input type="text" name="talla" class="form-control" required>
    </div>
     <div class="col-md-6">
        <label class="form-label">Fecha del Procedimiento</label>
        <input type="date" name="fecha_procedimiento" class="form-control" required>
    </div>
    <div class="col-12">
        <label class="form-label">Observación</label>
        <textarea name="observacion" class="form-control" rows="3"></textarea>
    </div>
    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-success fw-bold w-100" style="font-size:1.15rem; letter-spacing:0.5px;">
            Aceptar
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-procedimiento');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch('guardar_procedimiento.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if (data.includes('exitosamente')) {
                alert('Procedimiento registrado exitosamente');
                form.reset();

                // Mostrar la pestaña "Contacto Emergencia"
                const contactoTab = new bootstrap.Tab(document.querySelector('#tab-contacto-emergencia'));
                contactoTab.show();
            } else {
                alert('Error al guardar: ' + data);
            }
        })
        .catch(error => {
            alert('Error en la solicitud: ' + error);
        });
    });
});
</script>