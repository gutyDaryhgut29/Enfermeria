<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'] ?? null;
    $nombre_enfermedad = trim($_POST['nombre_enfermedad'] ?? null);
    $se_controla = $_POST['se_controla'] ?? 'No';
    $toma_medicamento = $_POST['toma_medicamento'] ?? 'No';
    $medicamento = trim($_POST['medicamento'] ?? null);
    $observaciones = trim($_POST['observaciones'] ?? null);

    try {
        $stmt = $pdo->prepare("SELECT paciente_id FROM paciente WHERE cedula = ?");
        $stmt->execute([$cedula]);
        $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($paciente) {
            $paciente_id = $paciente['paciente_id'];

            // Revisar si ya hay registro
            $check = $pdo->prepare("SELECT enfermedad_id FROM enfermedad_personal WHERE paciente_id = ?");
            $check->execute([$paciente_id]);
            $existe = $check->fetch(PDO::FETCH_ASSOC);

            if ($existe) {
                // Actualizar si ya existe
                $sql = "UPDATE enfermedad_personal 
                        SET nombre_enfermedad = ?, se_controla = ?, toma_medicamento = ?, medicamento = ?, observaciones = ?
                        WHERE paciente_id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nombre_enfermedad, $se_controla, $toma_medicamento, $medicamento, $observaciones, $paciente_id]);
            } else {
                // Insertar si no existe
                $sql = "INSERT INTO enfermedad_personal 
                        (paciente_id, nombre_enfermedad, se_controla, toma_medicamento, medicamento, observaciones)
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$paciente_id, $nombre_enfermedad, $se_controla, $toma_medicamento, $medicamento, $observaciones]);
            }

            echo "exitosamente"; // ✅ MENSAJE PLANO para el fetch()
        } else {
            echo "Paciente no encontrado con esa cédula.";
        }

    } catch (PDOException $e) {
        echo "Error al guardar: " . $e->getMessage();
    }
}
