<?php
require 'conexion.php';
$stmt = $pdo->query("SELECT paciente_id, nombre, cedula FROM paciente ORDER BY nombre");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="antecedente-familiar-content">
<form method="POST" class="row g-3" id="form-antecedente-familiar">
    <div class="col-md-6">
        <label class="form-label">Cédula</label>
        <input type="text" name="cedula" class="form-control" placeholder="Ingrese la cédula del paciente" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">¿Tiene enfermedad?</label>
        <select name="tiene_enfermedad" class="form-select" required>
            <option value="Sí">Sí</option>
            <option value="No">No</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="3" placeholder="Ej: Diabetes, hipertensión, etc."></textarea>
    </div>
    <div class="col-12 mt-3">
        <button type="submit" class="btn w-100 fw-bold" style="background:#56ab2f;color:#fff;font-size:1.15rem;">Aceptar</button>
    </div>
</form>
</div>

<script>
// Manejo AJAX para guardar antecedente familiar y cambiar de pestaña
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-antecedente-familiar');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch('guardar_antecedente_familiar.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if (data.includes('exitosamente')) {
                alert('Antecedente familiar registrado exitosamente');
                form.reset();

                // Cambiar a la pestaña "Antecedente Quirúrgico"
                const quirurgicoTab = new bootstrap.Tab(document.querySelector('#tab-antecedente-quirurgico'));
                quirurgicoTab.show();
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
