<?php
require 'conexion.php';
?>

<form method="POST" class="row g-3" id="form-enfermedad-personal">
    <div class="col-md-6">
        <label class="form-label">Cédula</label>
        <input type="text" name="cedula" class="form-control" placeholder="Ingrese la cédula del paciente" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Nombre de la enfermedad</label>
        <input type="text" name="nombre_enfermedad" class="form-control" placeholder="Ej: Asma, Diabetes..." required>
    </div>

    <div class="col-md-6">
        <label class="form-label">¿Se controla?</label>
        <select name="se_controla" class="form-select" required>
            <option value="">Seleccione una opción</option>
            <option value="Sí">Sí</option>
            <option value="No">No</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">¿Toma medicamento?</label>
        <select name="toma_medicamento" class="form-select" required>
            <option value="">Seleccione una opción</option>
            <option value="Sí">Sí</option>
            <option value="No">No</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Nombre del medicamento (si aplica)</label>
        <input type="text" name="medicamento" class="form-control" placeholder="Ej: Insulina, Salbutamol...">
    </div>

    <div class="col-md-6">
        <label class="form-label">Observaciones</label>
        <textarea name="observaciones" class="form-control" rows="3" placeholder="Observaciones adicionales..."></textarea>
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn w-100 fw-bold" style="background:#56ab2f;color:#fff;font-size:1.15rem;">Aceptar</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-enfermedad-personal');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch('guardar_enfermedad_personal.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if (data.includes('exitosamente')) {
                alert('Enfermedad personal guardada exitosamente');
                form.reset();

                // Ir a la pestaña de Procedimientos
                const procTab = new bootstrap.Tab(document.querySelector('#tab-procedimiento'));
                procTab.show();
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
