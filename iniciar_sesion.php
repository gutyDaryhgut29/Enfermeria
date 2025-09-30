<?php
session_start();
require 'conexion.php';

$error = '';
$usuario = '';

if (isset($_GET['registro']) && $_GET['registro'] == 'exito') {
    $mensaje_exito = "Registro exitoso. Por favor inicia sesión.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);
    $clave = $_POST['clave'];

    // Buscar usuario por nombre
    $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
        // Si la contraseña está encriptada, usa password_verify
        if (isset($user['contraseña']) && (password_verify($clave, $user['contraseña']) || $clave === $user['contraseña'])) {
            $_SESSION['nombre_usuario'] = $user['nombre_usuario'];
            $_SESSION['cargo'] = $user['cargo'];
            $_SESSION['nombre'] = $user['nombre'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Usuario o contraseña incorrecta";
        }
    } else {
        $error = "Usuario o contraseña incorrecta";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100" style="background: linear-gradient(135deg, #e8f5e9 60%, #b2dfdb 100%);">
<div class="card p-4 shadow-lg border-0" style="width: 370px; border-radius: 20px;">
    <div class="text-center mb-3">
        <div class="icon-circle-login mb-2">
            <i class="bi bi-person-circle"></i>
        </div>
        <h4 class="fw-bold mb-0" style="color:#256029;letter-spacing:1px;">Iniciar Sesión</h4>
    </div>
    <?php
    if (!empty($mensaje_exito)) {
        echo "<div class='alert alert-success'>$mensaje_exito</div>";
    }
    if (!empty($error)) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
    ?>
    <form method="POST" action="iniciar_sesion.php">
        <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input type="text" name="usuario" class="form-control" required value="<?= htmlspecialchars($usuario) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="clave" class="form-control" required>
        </div>
        <button class="btn w-100 fw-bold" style="background:#56ab2f;color:#fff;">Entrar</button>
    </form>
 
<style>
.icon-circle-login {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #a8e063;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.3rem;
    color: #256029;
    margin: 0 auto;
    box-shadow: 0 2px 8px rgba(67,160,71,0.10);
}
.card {
    border-radius: 20px !important;
}
</style>
</body>
</html>
