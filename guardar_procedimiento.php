<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = trim($_POST['cedula'] ?? '');
    $procedimiento = trim($_POST['procedimiento'] ?? '');
    $peso = trim($_POST['peso'] ?? '');
    $talla = trim($_POST['talla'] ?? '');
    $fecha = trim($_POST['fecha_procedimiento'] ?? date('Y-m-d'));
    $observacion = trim($_POST['observacion'] ?? '');

    $personal_id = 1; // Si usas login con personal, cambia a $_SESSION['personal_id']

    if (empty($cedula) || empty($procedimiento)) {
        echo "Cédula y procedimiento son obligatorios.";
        exit;
    }

    try {
        // Buscar paciente_id
        $stmt = $pdo->prepare("SELECT paciente_id FROM paciente WHERE cedula = ?");
        $stmt->execute([$cedula]);
        $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$paciente) {
            echo "No se encontró un paciente con esa cédula.";
            exit;
        }

        $paciente_id = $paciente['paciente_id'];

        // 🔴 ELIMINAR todos los procedimientos anteriores del paciente
        $borrar = $pdo->prepare("DELETE FROM procedimiento WHERE paciente_id = ?");
        $borrar->execute([$paciente_id]);

        // ✅ INSERTAR el nuevo procedimiento
        $sql = "INSERT INTO procedimiento 
                (paciente_id, personal_id, procedimiento, peso, talla, fecha_procedimiento, observacion)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $paciente_id,
            $personal_id,
            $procedimiento,
            $peso,
            $talla,
            $fecha,
            $observacion
        ]);

        echo "exitosamente";
    } catch (PDOException $e) {
        echo "Error al guardar: " . $e->getMessage();
    }
}
?>
