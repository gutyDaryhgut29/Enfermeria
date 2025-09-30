<?php
require 'conexion.php';
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_GET['paciente_id'])) {
    die('Paciente no especificado.');
}
$id = intval($_GET['paciente_id']);
$stmt = $pdo->prepare("SELECT * FROM paciente WHERE paciente_id = ?");
$stmt->execute([$id]);
$datos = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$datos) die('Paciente no encontrado.');

// Traer datos relacionados
$af = $pdo->prepare("SELECT * FROM antecedente_familiar WHERE paciente_id = ?");
$af->execute([$id]);
$antecedentes_familiares = $af->fetchAll(PDO::FETCH_ASSOC);

$aq = $pdo->prepare("SELECT * FROM antecedente_quirurgico WHERE paciente_id = ?");
$aq->execute([$id]);
$antecedentes_quirurgicos = $aq->fetchAll(PDO::FETCH_ASSOC);

$ep = $pdo->prepare("SELECT * FROM enfermedad_personal WHERE paciente_id = ?");
$ep->execute([$id]);
$enfermedades_personales = $ep->fetchAll(PDO::FETCH_ASSOC);

$cs = $pdo->prepare("SELECT * FROM consulta WHERE paciente_id = ?");
$cs->execute([$id]);
$consultas = $cs->fetchAll(PDO::FETCH_ASSOC);

$pr = $pdo->prepare("SELECT * FROM procedimiento WHERE paciente_id = ?");
$pr->execute([$id]);
$procedimientos = $pr->fetchAll(PDO::FETCH_ASSOC);

$em = $pdo->prepare("SELECT * FROM inf_embarazo WHERE paciente_id = ?");
$em->execute([$id]);
$embarazos = $em->fetchAll(PDO::FETCH_ASSOC);

$ce = $pdo->prepare("SELECT * FROM contacto_emergencia WHERE paciente_id = ?");
$ce->execute([$id]);
$contactos = $ce->fetchAll(PDO::FETCH_ASSOC);

// Generar HTML
ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1, h2 { color: #256029; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        .section { margin-bottom: 20px; }
        .title { font-size: 18px; margin-bottom: 5px; }
    </style>
</head>
<body>

<h1 style="text-align:center;">Expediente Clínico</h1>
<p style="text-align:center;">Generado <?= date('d/m/Y H:i') ?></p>

<div class="section">
    <h2>Datos Personales</h2>
    <table>
        <tr><th>Nombre</th><td><?= htmlspecialchars($datos['nombre']) ?></td></tr>
        <tr><th>Cédula</th><td><?= htmlspecialchars($datos['cedula']) ?></td></tr>
        <tr><th class="bg-light">EDAD</th><td><?= calcularEdad($datos['fecha_nacimiento']) ?></td>
        <tr><th>Sexo</th><td><?= htmlspecialchars($datos['sexo']) ?></td></tr>
        <tr><th>Teléfono</th><td><?= htmlspecialchars($datos['telefono']) ?></td></tr>
        <tr><th>Dirección</th><td><?= htmlspecialchars($datos['direccion']) ?></td></tr>
        <tr><th>Estado Civil</th><td><?= htmlspecialchars($datos['estado_civil']) ?></td></tr>
        <tr><th>Tipo Paciente</th><td><?= htmlspecialchars($datos['tipo_paciente']) ?></td></tr>
        <tr><th>Frecuencia Médico</th><td><?= htmlspecialchars($datos['frecuencia_medico']) ?></td></tr>
        <tr><th>Alérgico</th><td><?= htmlspecialchars($datos['alergico']) ?></td></tr>
    </table>
</div>

<?php
function renderSection($title, $items, $columns, $emptyText) {
    echo "<div class='section'><h2>$title</h2>";
    if ($items) {
        echo "<table><thead><tr>";
        foreach ($columns as $col) echo "<th>$col</th>";
        echo "</tr></thead><tbody>";
        foreach ($items as $item) {
            echo "<tr>";
            foreach ($columns as $key => $label) {
                echo "<td>" . htmlspecialchars($item[$key]) . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>$emptyText</p>";
    }
    echo "</div>";
}
function calcularEdad($fecha_nacimiento) {
    if (!$fecha_nacimiento) return '-';
    $nacimiento = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($nacimiento);
    return $edad->y . ' años, ' . $edad->m . ' meses, ' . $edad->d . ' días';
}


renderSection('Antecedentes Familiares', $antecedentes_familiares, [
    'tiene_enfermedad' => 'Tiene enfermedad',
    'descripcion' => 'Descripción',
    
], 'Sin antecedentes familiares registrados.');

renderSection('Antecedentes Quirúrgicos', $antecedentes_quirurgicos, [
    'cirugia' => 'Cirugía',
    'anio' => 'año',
    'observaciones' => 'observaciones'
], 'Sin antecedentes quirúrgicos registrados.');

renderSection('Enfermedades Personales', $enfermedades_personales, [
    'nombre_enfermedad' => 'Enfermedad',
    'observaciones' => 'observaciones',
], 'Sin enfermedades personales registradas.');

renderSection('Consultas', $consultas, [
    'fecha_consulta' => 'Fecha',
    'motivo' => 'Motivo',
    'recomendaciones' => 'Recomendacion'

], 'Sin consultas registradas.');

renderSection('Procedimientos', $procedimientos, [
    'fecha_procedimiento' => 'Fecha',
    'procedimiento' => 'Procedimiento',
    'peso' => 'Peso',
    'talla' => 'Talla',
    'observacion' => 'Observacion'
], 'Sin procedimientos registrados.');

renderSection('Información de Embarazo', $embarazos, [
    'cant_embarazos' => 'Embarazos',
    'cant_partos' => 'Partos',
    'cesarea' => 'Cesáreas',
    'cant_abortos' => 'Abortos'
], 'Sin información de embarazo registrada.');

renderSection('Contactos de Emergencia', $contactos, [
    'nombre_contacto' => 'Nombre',
    'parentesco' => 'Parentesco',
    'telefono_contacto' => 'Teléfono'
], 'Sin contactos de emergencia registrados.');
?>

<!-- Campo de firma al final -->
<!-- Campo de firma con encabezado institucional -->
<div style="margin-top: 60px;">
    <table style="width: 100%; border: none;">
        <tr>
            <td style="width: 50%; text-align: left;">
                <p><strong>Verificado por:</strong></p>
                <p style="margin-top: 40px;"></p>
                <p>Nombre y Firma</p>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: bottom;">
                <p><strong>Departamento de Enfermería</strong><br>Centro Regional de Coclé</p>
            </td>
        </tr>
    </table>
</div>


</body>
</html>
<?php
$html = ob_get_clean();

// Opciones Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('expediente_paciente.pdf', ['Attachment' => true]);
?>