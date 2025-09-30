<?php
session_start();
require 'conexion.php';

$nombre = $cedula = $cargo = $nombre_usuario = '';
$error = '';
$exito = false;
$adminValidado = false;

//Cambio desde mi computadora personal
//Otro comentario

// 🔒 Validar login
if (!isset($_SESSION['usuario'])) {
    $error = "Debe iniciar sesión para acceder a esta página.";
} else {
    // Si ya es administrador real, puede pasar directo
    if ($_SESSION['cargo'] === 'Administrador') {
        $adminValidado = true;
    }

    // Paso 1: Validación manual de administrador (para los que no tienen rol admin en sesión)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validar_admin'])) {
        $nombreAdmin = trim($_POST['val_nombre']);
        $cedulaAdmin = trim($_POST['val_cedula']);
        $cargoAdmin = $_POST['val_cargo'];

        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombre = ? AND cedula = ? AND cargo = 'Administrador'");
        $stmt->execute([$nombreAdmin, $cedulaAdmin]);
        $admin = $stmt->fetch();

        if ($admin) {
            $adminValidado = true;
        } else {
            $error = "Los datos no corresponden a un administrador autorizado.";
        }
    }

    // Paso 2: Si ya está validado (porque es admin real o pasó la validación), permitir registro de usuario
    if ($adminValidado && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar_usuario'])) {
        $nombre = trim($_POST['nombre']); 
        $cedula = trim($_POST['cedula']); 
        $cargo = $_POST['cargo']; 
        $nombre_usuario = trim($_POST['nombre_usuario']); 
        $clave = $_POST['clave']; 

        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        // Verificar si ya existe usuario
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombre_usuario = ?");
        $stmt->execute([$nombre_usuario]);

        if ($stmt->rowCount() > 0) {
            $error = "Ese nombre de usuario ya existe.";
        } else {
            $sql = "INSERT INTO usuario (nombre, cedula, cargo, nombre_usuario, contraseña)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([$nombre, $cedula, $cargo, $nombre_usuario, $claveHash]);

            if ($resultado) {
                $exito = true;
            } else {
                $error = "Error al registrar el usuario. Intente nuevamente.";
            }
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="bg-simple">
  <div class="card-clean">
    <div class="text-center mb-4">
      <div style="font-size:2.5rem;color:#56ab2f;"><i class="bi bi-person-plus"></i></div>
      <h4 class="fw-bold mb-0" style="color:#256029;letter-spacing:1px;">Registrar Usuario</h4>
      <div class="mt-3 mb-2 text-start">
        <a href="index.php" class="btn btn-outline-success fw-bold">&larr; Atrás</a>
      </div>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger text-center py-2 mb-3"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($exito): ?>
      <div class="alert alert-success text-center py-2 mb-3">Usuario registrado correctamente.</div>
    <?php endif; ?>

    <?php if (!$adminValidado): ?>
      <!-- Formulario de validación de administrador -->
      <div class="alert alert-warning text-center py-2 mb-3">
        Valide que sea administrador para poder registrar usuarios.
      </div>
      <form method="POST" action="registrar_usuario.php" autocomplete="off">
        <input type="hidden" name="validar_admin" value="1">
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-person"></i></span>
          <input type="text" name="val_nombre" class="form-control" placeholder="Nombre del administrador" required>
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
          <input type="text" name="val_cedula" class="form-control" placeholder="Cédula del administrador" required>
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
          <select name="val_cargo" class="form-select" required>
            <option value="Administrador">Administrador</option>
          </select>
        </div>
        <button type="submit" class="btn w-100 fw-bold">Validar Administrador</button>
      </form>

    <?php else: ?>
      <!-- Formulario de registro de usuario -->
      <form method="POST" action="registrar_usuario.php" id="form-usuario" autocomplete="off">
        <input type="hidden" name="registrar_usuario" value="1">
        <div class="row row-cols-1 row-cols-md-2 g-4">
          <div class="col">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" name="nombre" class="form-control" required placeholder="Nombre completo" value="<?= htmlspecialchars($nombre) ?>">
            </div>
          </div>
          <div class="col">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
              <input type="text" name="cedula" class="form-control" required placeholder="Cédula" value="<?= htmlspecialchars($cedula) ?>">
            </div>
          </div>
          <div class="col">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
              <select name="cargo" class="form-select" required>
                <option value="" disabled selected hidden>Seleccione un cargo</option>
                <option value="Enfermera">Enfermera</option>
                <option value="Doctor">Doctor</option>
                <option value="Administrador">Administrador</option>
              </select>
            </div>
          </div>
          <div class="col">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
              <input type="text" name="nombre_usuario" class="form-control" required placeholder="Nombre de usuario" value="<?= htmlspecialchars($nombre_usuario) ?>">
            </div>
          </div>
          <div class="col">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="clave" class="form-control" required placeholder="Contraseña">
            </div>
          </div>
        </div>
        <button type="submit" class="btn w-100 fw-bold mt-2">Registrar Usuario</button>
      </form>
    <?php endif; ?>
  </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
