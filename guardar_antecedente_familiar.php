<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $tiene_enfermedad = $_POST['tiene_enfermedad'];
    $descripcion = $_POST['descripcion'];

    try {
        // Buscar paciente_id desde la cédula
        $stmt = $pdo->prepare("SELECT paciente_id FROM paciente WHERE cedula = ?");
        $stmt->execute([$cedula]);
        $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($paciente && isset($paciente['paciente_id'])) {
            $paciente_id = $paciente['paciente_id'];

            // Verificar si ya existe un antecedente familiar para este paciente
            $check = $pdo->prepare("SELECT * FROM antecedente_familiar WHERE paciente_id = ?");
            $check->execute([$paciente_id]);

            if ($check->rowCount() > 0) {
                // Ya existe: hacer UPDATE
                $sql = "UPDATE antecedente_familiar 
                        SET tiene_enfermedad = ?, descripcion = ? 
                        WHERE paciente_id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$tiene_enfermedad, $descripcion, $paciente_id]);

                echo "Antecedente familiar actualizado exitosamente";
            } else {
                // No existe: hacer INSERT
                $sql = "INSERT INTO antecedente_familiar (paciente_id, tiene_enfermedad, descripcion)
                        VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$paciente_id, $tiene_enfermedad, $descripcion]);

                echo "Antecedente familiar registrado exitosamente";
            }

        } else {
            echo "No se encontró un paciente con la cédula: " . htmlspecialchars($cedula);
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>