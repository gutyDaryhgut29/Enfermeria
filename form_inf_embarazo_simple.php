<?php
require 'conexion.php';
$stmt = $pdo->query("SELECT paciente_id, nombre, cedula FROM paciente ORDER BY nombre");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Eliminado: este formulario ya no se usará como pestaña independiente, ahora está integrado en el registro de paciente -->
