<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre_contacto'];
    $telefono = $_POST['telefono_contacto'];
    $parentesco = $_POST['parentesco'] ?? '';

    try {
        // Buscar paciente_id usando la cédula
        $stmt = $pdo->prepare("SELECT paciente_id FROM paciente WHERE cedula = ?");
        $stmt->execute([$cedula]);
        $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($paciente) {
            $paciente_id = $paciente['paciente_id'];

            // Insertar contacto de emergencia
            $sql = "INSERT INTO contacto_emergencia (paciente_id, nombre_contacto, telefono_contacto, parentesco)
                    VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$paciente_id, $nombre, $telefono, $parentesco]);

            echo "Contacto de emergencia registrado exitosamente";
        } else {
            echo "Error: No se encontró ningún paciente con esa cédula.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
