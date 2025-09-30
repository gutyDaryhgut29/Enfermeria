<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $paciente_id = $_POST['paciente_id'];
    $fecha = $_POST['fecha_consulta'];
    $motivo = $_POST['motivo'];
    $recomendaciones = $_POST['recomendaciones'];
    $intervencion = $_POST['intervencion_enfermeria'];

    try {
        $sql = "INSERT INTO consulta (paciente_id, fecha_consulta, motivo, recomendaciones, intervencion_enfermeria)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$paciente_id, $fecha, $motivo, $recomendaciones, $intervencion]);

        echo "<script>alert('Consulta registrada exitosamente'); window.location='registrar_consulta.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
