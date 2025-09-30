<?php require 'conexion.php'; ?>

<form method="POST" class="row g-3" id="form-antecedente-quirurgico">
    <div class="col-md-6">
        <label class="form-label">Cédula</label>
        <input type="text" name="cedula" class="form-control" placeholder="Ingrese la cédula del paciente" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Cirugía realizada</label>
        <input type="text" name="cirugia" class="form-control" required placeholder="Ej: Apendicectomía, Cesárea...">
    </div>

    <div class="col-md-6">
        <label class="form-label">Año de la cirugía</label>
        <input type="number" name="anio" class="form-control" placeholder="Ej: 2020" min="1900" max="2100">
    </div>

    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea name="observaciones" class="form-control" rows="3" placeholder="Detalles adicionales si los hay..."></textarea>
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-success w-100 fw-bold" style="font-size: 1.15rem;">
            Guardar
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-antecedente-quirurgico');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch('guardar_antecedente_quirurgico.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if (data.includes('exitosamente')) {
                alert('Antecedente quirúrgico guardado exitosamente');
                form.reset();

                // Avanzar a la siguiente pestaña si aplica
                const sigTab = new bootstrap.Tab(document.querySelector('#tab-enfermedad-personal'));
                sigTab.show();
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
