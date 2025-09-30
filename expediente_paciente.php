<?php
session_start();
require 'conexion.php';             
include 'includes/header.php';       

$stmt  = $pdo->query("SELECT paciente_id, nombre, cedula FROM paciente ORDER BY nombre");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$datos = null;
if (isset($_GET['paciente_id']) && filter_var($_GET['paciente_id'], FILTER_VALIDATE_INT)) {
    $id = (int) $_GET['paciente_id'];

    $stmt = $pdo->prepare("SELECT * FROM paciente WHERE paciente_id = ?");
    $stmt->execute([$id]);
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($datos) {
        $af = $pdo->prepare("SELECT * FROM antecedente_familiar WHERE paciente_id = ?");
        $af->execute([$id]);
        $antecedentes_familiares = $af->fetchAll(PDO::FETCH_ASSOC);

        $aq = $pdo->prepare("SELECT * FROM antecedente_quirurgico WHERE paciente_id = ?");
        $aq->execute([$id]);
        $antecedentes_quirurgicos = $aq->fetchAll(PDO::FETCH_ASSOC);

        $ep = $pdo->prepare("SELECT * FROM enfermedad_personal WHERE paciente_id = ?");
        $ep->execute([$id]);
        $enfermedades_personales = $ep->fetchAll(PDO::FETCH_ASSOC);

        $cs = $pdo->prepare("SELECT * FROM consulta WHERE paciente_id = ? ORDER BY fecha_consulta DESC");
        $cs->execute([$id]);
        $consultas = $cs->fetchAll(PDO::FETCH_ASSOC);

        $pr = $pdo->prepare("SELECT * FROM procedimiento WHERE paciente_id = ? ORDER BY fecha_procedimiento DESC");
        $pr->execute([$id]);
        $procedimientos = $pr->fetchAll(PDO::FETCH_ASSOC);

        $em = $pdo->prepare("SELECT * FROM inf_embarazo WHERE paciente_id = ?");
        $em->execute([$id]);
        $embarazos = $em->fetchAll(PDO::FETCH_ASSOC);

        $ce = $pdo->prepare("SELECT * FROM contacto_emergencia WHERE paciente_id = ?");
        $ce->execute([$id]);
        $contactos = $ce->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!$datos || !is_array($datos)) {
    echo '<div class="alert alert-danger m-5">Paciente no encontrado o datos inválidos.</div>';
    include 'includes/footer.php';
    exit;
}

function calcularEdad($fecha_nac) {
    if (!$fecha_nac) return '-';
    $nacimiento = new DateTime($fecha_nac);
    $hoy = new DateTime();
    $edad = $hoy->diff($nacimiento);
    return $edad->y . ' años, ' . $edad->m . ' meses, ' . $edad->d . ' días';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Historia Clínica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="background:linear-gradient(135deg,#e8f5e9 60%,#b2dfdb 100%);min-height:100vh;">
<div class="d-flex" style="min-height:100vh;">
    <?php include 'includes/sidebar.php'; ?>
    <main class="flex-grow-1 p-4">
        <div class="expediente-ficha mx-auto my-4">
            <h2 class="titulo-expediente mb-3">EXPEDIENTE CLÍNICO</h2>

            <!-- DATOS PERSONALES -->
            <table class="table table-bordered mb-3 ficha-datos-personales">
                <tbody>
                    <tr><th class="bg-light">APELLIDOS Y NOMBRES:</th><td colspan="3"><?= htmlspecialchars($datos['nombre']) ?></td></tr>
                    <tr><th class="bg-light">FECHA NACIMIENTO</th><td><?= htmlspecialchars($datos['fecha_nacimiento']) ?></td>
                        <th class="bg-light">Cédula</th><td><?= htmlspecialchars($datos['cedula']) ?></td></tr>
                    <tr><th class="bg-light">EDAD</th><td><?= calcularEdad($datos['fecha_nacimiento']) ?></td>
                        <th class="bg-light">SEXO</th><td><?= htmlspecialchars($datos['sexo']) ?></td></tr>
                    <tr><th class="bg-light">ESTADO CIVIL</th><td><?= htmlspecialchars($datos['estado_civil'] ?? '') ?></td>
                        <th class="bg-light">Dirección</th><td><?= htmlspecialchars($datos['direccion']) ?></td></tr>
                    <tr><th class="bg-light">TELÉFONO</th><td><?= htmlspecialchars($datos['telefono']) ?></td>
                        <th class="bg-light">PERSONA RESPONSABLE</th><td>
        <?php
        if (!empty($contactos)) {
            $responsable = $contactos[0];
            echo htmlspecialchars($responsable['nombre_contacto']);
            if (!empty($responsable['parentesco'])) {
                echo ' <span class="text-muted">(' . htmlspecialchars($responsable['parentesco']) . ')</span>';
            }
        } else {
            echo '-';
        }
        ?>
    </td></tr>
                </tbody>
            </table>


<!-- CONSULTAS -->
<table class="table table-bordered mb-3 ficha-datos-consulta">
    <thead class="table-light">
        <tr>
            <th class="bg-light">Fecha Atención</th>
            <th class="bg-light">Motivo de la Consulta</th>
            <th class="bg-light">Recomendación</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($consultas)): ?>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?= htmlspecialchars($consulta['fecha_consulta']) ?></td>
                    <td><?= htmlspecialchars($consulta['motivo']) ?></td>
                    <td><?= htmlspecialchars($consulta['recomendaciones'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">No hay consultas registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>


<!-- ANTECEDENTES FAMILIARES -->
<table class="table table-bordered mb-3 ficha-datos-personales">
    <thead class="table-light">
        <tr><th colspan="2">ANTECEDENTES FAMILIARES</th></tr>
        <tr>
            <th class="bg-light">¿Tiene Enfermedad?</th>
            <th class="bg-light">Descripción</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($antecedentes_familiares)): ?>
            <?php foreach ($antecedentes_familiares as $af): ?>
                <tr>
                    <td><?= htmlspecialchars($af['tiene_enfermedad']) ?></td>
                    <td><?= htmlspecialchars($af['descripcion'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="2">No hay antecedentes familiares registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>


            <!-- ANTECEDENTES QUIRÚRGICOS -->
            <table class="table table-bordered mb-3 ficha-datos-personales">
                <thead class="table-light">
                    <tr><th colspan="3">ANTECEDENTES QUIRÚRGICOS</th></tr>
                    <tr>
                        <th class="bg-light">Cirugía</th>
                        <th class="bg-light">Año</th>
                        <th class="bg-light">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($antecedentes_quirurgicos)): ?>
                        <?php foreach ($antecedentes_quirurgicos as $aq): ?>
                            <tr>
                                <td><?= htmlspecialchars($aq['cirugia']) ?></td>
                                <td><?= htmlspecialchars($aq['anio'] ?? '') ?></td>
                                <td><?= htmlspecialchars($aq['observaciones'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3">N/A</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- ENFERMEDADES PERSONALES -->
            <table class="table table-bordered mb-3 ficha-datos-personales">
                <thead class="table-light">
                    <tr><th colspan="2">ENFERMEDADES PERSONALES</th></tr>
                    <tr>
                        <th class="bg-light">Nombre de la Enfermedad</th>
                        <th class="bg-light">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($enfermedades_personales)): ?>
                        <?php foreach ($enfermedades_personales as $ep): ?>
                            <tr>
                                <td><?= htmlspecialchars($ep['nombre_enfermedad']) ?></td>
                                <td><?= htmlspecialchars($ep['observaciones']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="2">N/A</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

<!-- PROCEDIMIENTOS -->
<table class="table table-bordered mb-3 ficha-datos-personales">
    <thead class="table-light">
        <tr><th colspan="5">PROCEDIMIENTOS</th></tr>
        <tr>
            <th class="bg-light">Fecha</th>
            <th class="bg-light">Procedimiento</th>
            <th class="bg-light">Peso</th>
            <th class="bg-light">Talla</th>
            <th class="bg-light">Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($procedimientos)): ?>
            <?php foreach ($procedimientos as $pr): ?>
                <tr>
                    <td><?= htmlspecialchars($pr['fecha_procedimiento']) ?></td>
                    <td><?= htmlspecialchars($pr['procedimiento'] ?? '') ?></td>
                    <td><?= htmlspecialchars($pr['peso'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($pr['talla'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($pr['observacion'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No hay procedimientos registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>


            <!-- INFORMACIÓN ADICIONAL -->
            <!-- Se elimina la tabla de vacunas, presión, temperatura, frecuencia respiratoria y saturación -->

            <!-- EMBARAZOS -->
            <?php if ($embarazos && count($embarazos) > 0): ?>
                <table class="table table-bordered mb-3 ficha-datos-personales">
                    <thead class="table-light">
                        <tr><th colspan="4">INFORMACIÓN DE EMBARAZO</th></tr>
                        <tr>
                            <th class="bg-light">Embarazos</th>
                            <th class="bg-light">Partos</th>
                            <th class="bg-light">Cesáreas</th>
                            <th class="bg-light">Abortos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $e = $embarazos[count($embarazos)-1]; // Solo la última fila ?>
                        <tr>
                            <td><?= $e['cant_embarazos'] ?></td>
                            <td><?= $e['cant_partos'] ?></td>
                            <td><?= $e['cesarea'] ?></td>
                            <td><?= $e['cant_abortos'] ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>

            <!-- CONTACTOS DE EMERGENCIA -->
            <?php if ($contactos): ?>
                <table class="table table-bordered mb-3 ficha-datos-personales">
                    <thead class="table-light">
                        <tr><th colspan="2">CONTACTOS DE EMERGENCIA</th></tr>
                        <tr>
                            <th class="bg-light">Nombre</th>
                            <th class="bg-light">Parentesco</th>
                            <th class="bg-light">Teléfono</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contactos as $c): ?>
                        <tr>
                            <td><?= $c['nombre_contacto'] ?></td>
                            <td><?= $c['parentesco'] ?></td>
                            <td><?= $c['telefono_contacto'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <!-- BOTONES -->
            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="expediente_pdf.php?paciente_id=<?= $datos['paciente_id'] ?>" class="btn btn-primary"><i class="bi bi-download"></i> Descargar PDF</a>
                <a href="editar_paciente.php?id=<?= $datos['paciente_id'] ?>" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Editar</a>
                <a href="#" class="btn btn-danger" onclick="eliminarExpediente(<?= $datos['paciente_id'] ?>); return false;"><i class="bi bi-trash"></i> Eliminar</a>
            </div>
        </div>
    </main>
</div>

<script>
function eliminarExpediente(id) {
    if (confirm('¿Seguro que deseas eliminar este paciente? Esta acción no se puede deshacer.')) {
        fetch('eliminar_paciente.php?id=' + id)
            .then(res => res.text())
            .then(data => {
                if (data.includes('Paciente eliminado correctamente')) {
                    alert('Paciente eliminado correctamente');
                    window.location.href = 'listar_pacientes.php';
                } else {
                    alert('Error al eliminar: ' + data);
                }
            }).catch(err => alert('Error en la solicitud: ' + err));
    }
}
</script>

<style>
.expediente-ficha {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(67,160,71,0.10);
    padding: 2.5rem 2rem;
    max-width: 900px;
    border: 1.5px solid #b2dfdb;
}
.titulo-expediente {
    text-align: center;
    color: #256029;
    font-weight: bold;
    letter-spacing: 1px;
    font-size: 2rem;
}
.table th, .table td {
    font-size: 1rem;
    padding: 0.45rem 0.7rem;
}
.table th.bg-light {
    background: #e8f5e9 !important;
    color: #256029;
    font-weight: 600;
}
</style>
</body>
</html>