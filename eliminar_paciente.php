<?php
require 'conexion.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<script>alert('ID inválido'); window.location='listar_pacientes.php';</script>";
    exit;
}

try {
    // Eliminar registros relacionados
    $pdo->prepare("DELETE FROM antecedente_familiar WHERE paciente_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM antecedente_quirurgico WHERE paciente_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM enfermedad_personal WHERE paciente_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM consulta WHERE paciente_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM procedimiento WHERE paciente_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM inf_embarazo WHERE paciente_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM contacto_emergencia WHERE paciente_id = ?")->execute([$id]);

    // Ahora sí eliminar el paciente
    $stmt = $pdo->prepare("DELETE FROM paciente WHERE paciente_id = ?");
    $stmt->execute([$id]);

    echo "<script>alert('Paciente eliminado correctamente'); window.location='listar_pacientes.php';</script>";
} catch (PDOException $e) {
    echo "Error al eliminar: " . $e->getMessage();
}