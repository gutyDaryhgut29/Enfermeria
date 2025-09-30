<form action="guardar_paciente.php" method="POST" class="row g-3" id="form-paciente">
    <div class="col-md-6">
        <label class="form-label">Nombre completo</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Cédula</label>
        <input type="text" name="cedula" class="form-control" required id="cedula-input">
    </div>
    <div class="col-md-6">
        <label class="form-label">Fecha de nacimiento</label>
        <input type="date" name="fecha_nacimiento" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Sexo</label>
        <select name="sexo" class="form-select" id="sexo-select">
            <option value="M">M</option>
            <option value="F">F</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Estado civil</label>
        <select name="estado_civil" class="form-select">
            <option value="Soltero">Soltero</option>
            <option value="Casado">Casado</option>
            <option value="Unido">Unido</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Tipo de paciente</label>
        <select name="tipo_paciente" class="form-select form-control-lg" style="min-width:300px;max-width:100%;width:100%;">
            <option value="Estudiante">Estudiante</option>
            <option value="Profesor">Profesor</option>
            <option value="Administrativo">Administrativo</option>
            <option value="Externo">Externo</option>
        </select>
    </div>
    <!-- Frecuencia de visita al médico -->
<div class="col-md-6">
    <label class="form-label">Frecuencia de visita al médico</label>
    <select name="frecuencia_medico" class="form-select" required>
        <option value="">Seleccione una opción</option>
        <option value="diariamente">Diariamente</option>
        <option value="semanalmente">Semanalmente</option>
        <option value="mensualmente">Mensualmente</option>
        <option value="anualmente">Anualmente</option>
        <option value="nunca">Nunca</option>
    </select>
</div>

<!-- ¿Es alérgico a algún medicamento? -->
<div class="col-md-6">
    <label class="form-label">¿Es alérgico a algún medicamento?</label>
    <select name="alergico" class="form-select" required>
        <option value="">Seleccione una opción</option>
        <option value="si">Sí</option>
        <option value="no">No</option>
    </select>
</div>


    <div class="col-12">
        <label class="form-label">Dirección</label>
        <textarea name="direccion" class="form-control" rows="2"></textarea>
    </div>

    <!-- Campos de embarazo -->
    <div id="embarazo-fields" class="row g-4 align-items-end" style="display:none;">
        <div class="col-12 mt-3">
            <h6 class="fw-bold text-success">Información de Embarazo</h6>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">¿Ha estado embarazada?</label>
            <select name="ha_estado_embarazada" class="form-select">
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">Cantidad de embarazos</label>
            <input type="number" name="cant_embarazos" class="form-control" min="0">
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">Cantidad de partos</label>
            <input type="number" name="cant_partos" class="form-control" min="0">
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">Cantidad de cesáreas</label>
            <input type="number" name="cesarea" class="form-control" min="0">
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">Cantidad de abortos</label>
            <input type="number" name="cant_abortos" class="form-control" min="0">
        </div>
    </div>

    <div class="col-12 mt-3">
        <button class="btn w-100 fw-bold" style="background:#56ab2f;color:#fff;font-size:1.15rem;">Aceptar</button>
    </div>
</form>

<script>
// Mostrar campos de embarazo si es mujer
const sexoSelect = document.getElementById('sexo-select');
const embarazoFields = document.getElementById('embarazo-fields');
sexoSelect.addEventListener('change', function() {
    if (this.value === 'F') {
        embarazoFields.style.display = '';
    } else {
        embarazoFields.style.display = 'none';
        embarazoFields.querySelectorAll('input, select').forEach(el => {
            if (el.tagName === 'SELECT') el.selectedIndex = 0;
            else el.value = '';
        });
    }
});
if (sexoSelect.value === 'F') embarazoFields.style.display = '';

// Copiar cédula al siguiente formulario
document.getElementById('cedula-input').addEventListener('input', function() {
    const cedula = this.value;
    const cedulaDestino = document.getElementById('cedula-antecedente');
    if (cedulaDestino) {
        cedulaDestino.value = cedula;
    }
});
</script>
