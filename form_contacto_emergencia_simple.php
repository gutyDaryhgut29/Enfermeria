<?php
require 'conexion.php';
$stmt = $pdo->query("SELECT paciente_id, nombre, cedula FROM paciente ORDER BY nombre");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<form method="POST" class="row g-3" id="form-contacto-emergencia">
    <div class="col-md-6">
        <label class="form-label">Cédula</label>
        <input type="text" name="cedula" class="form-control" placeholder="Ingrese la cédula del paciente" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Nombre del contacto</label>
        <input type="text" name="nombre_contacto" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono_contacto" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Parentesco</label>
        <input type="text" name="parentesco" class="form-control" required>
    </div>
    <div class="col-12 mt-3">
        <button type="submit" class="btn w-100 fw-bold" style="background:#56ab2f;color:#fff;font-size:1.15rem;">Registrar</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-contacto-emergencia');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch('guardar_contacto_emergencia.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if (data.includes('exitosamente')) {
                alert('Contacto de emergencia registrado exitosamente');
                window.location.href = 'index.php'; // 🔁 Cambia si tu panel tiene otro nombre
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
