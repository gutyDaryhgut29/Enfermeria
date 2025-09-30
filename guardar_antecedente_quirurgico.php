<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = trim($_POST['cedula'] ?? '');
    $cirugia = trim($_POST['cirugia'] ?? '');
    $anio = $_POST['anio'] ?? null;
    $observaciones = trim($_POST['observaciones'] ?? '');

    if (empty($cedula) || empty($cirugia)) {
        echo "La cédula y la cirugía son obligatorias.";
        exit;
    }

    try {
        // Buscar paciente_id por cédula
        $stmt = $pdo->prepare("SELECT paciente_id FROM paciente WHERE cedula = ?");
        $stmt->execute([$cedula]);
        $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$paciente) {
            echo "No se encontró ningún paciente con esa cédula.";
            exit;
        }

        $paciente_id = $paciente['paciente_id'];

        // Guardar antecedente quirúrgico
        $insert = $pdo->prepare("INSERT INTO antecedente_quirurgico (paciente_id, cirugia, anio, observaciones)
                                 VALUES (?, ?, ?, ?)");
        $insert->execute([$paciente_id, $cirugia, $anio, $observaciones]);

        echo "Antecedente quirúrgico guardado exitosamente";
    } catch (Exception $e) {
        echo "Error al guardar: " . $e->getMessage();
    }
} else {
    echo "Método inválido.";
}
