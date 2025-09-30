<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);
    $cargo = trim($_POST['cargo']);

    try {
        $sql = "INSERT INTO personal_salud (nombre, cedula, cargo) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $cedula, $cargo]);
        echo "<script>alert('Personal de salud registrado exitosamente'); window.location='registrar_personal_salud.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
