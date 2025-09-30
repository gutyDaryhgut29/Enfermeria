<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];
    $estado_civil = $_POST['estado_civil'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $tipo_paciente = $_POST['tipo_paciente'];
    $frecuencia_medico = $_POST['frecuencia_medico'] ?? '';
    $alergico = $_POST['alergico'] ?? '';

    try {
        // Verificar si la cédula ya existe
        $verificar = $pdo->prepare("SELECT COUNT(*) FROM paciente WHERE cedula = ?");
        $verificar->execute([$cedula]);
        if ($verificar->fetchColumn() > 0) {
            echo 'duplicado';
            exit;
        }

        // Insertar nuevo paciente
        $sql = "INSERT INTO paciente (nombre, cedula, fecha_nacimiento, sexo, estado_civil, direccion, telefono, tipo_paciente, frecuencia_medico, alergico)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nombre, $cedula, $fecha_nacimiento, $sexo, $estado_civil,
            $direccion, $telefono, $tipo_paciente, $frecuencia_medico, $alergico
        ]);
        $paciente_id = $pdo->lastInsertId();

        // Si es femenino, guardar información de embarazo
        if ($sexo === 'F' && isset($_POST['ha_estado_embarazada'])) {
            $ha_estado_embarazada = $_POST['ha_estado_embarazada'];
            $cant_embarazos = $_POST['cant_embarazos'] ?? null;
            $cant_partos = $_POST['cant_partos'] ?? null;
            $cesarea = $_POST['cesarea'] ?? null;
            $cant_abortos = $_POST['cant_abortos'] ?? null;

            $sql_emb = "INSERT INTO inf_embarazo (paciente_id, ha_estado_embarazada, cant_embarazos, cant_partos, cesarea, cant_abortos)
                        VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_emb = $pdo->prepare($sql_emb);
            $stmt_emb->execute([$paciente_id, $ha_estado_embarazada, $cant_embarazos, $cant_partos, $cesarea, $cant_abortos]);
        }

        echo 'ok'; // Éxito
    } catch (PDOException $e) {
        echo 'error'; // Error general
    }
}
?>