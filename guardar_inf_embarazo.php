<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $paciente_id = $_POST['paciente_id'];
    $estado = $_POST['ha_estado_embarazada'];
    $embarazos = $_POST['cant_embarazos'];
    $partos = $_POST['cant_partos'];
    $cesarea = $_POST['cesarea'];
    $abortos = $_POST['cant_abortos'];

    try {
        // Eliminar cualquier registro anterior de embarazo para este paciente
        $eliminar = $pdo->prepare("DELETE FROM inf_embarazo WHERE paciente_id = ?");
        $eliminar->execute([$paciente_id]);

        // Insertar la nueva información de embarazo
        $sql = "INSERT INTO inf_embarazo (paciente_id, ha_estado_embarazada, cant_embarazos, cant_partos, cesarea, cant_abortos)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$paciente_id, $estado, $embarazos, $partos, $cesarea, $abortos]);

        echo "<script>alert('Información de embarazo guardada'); window.location='registrar_inf_embarazo.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>