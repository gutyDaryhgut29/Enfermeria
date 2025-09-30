<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Enfermería</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS e íconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* Reset global */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Header 100% adaptable */
        header {
            width: 100vw;
            background: linear-gradient(90deg, #43a047 60%, #a8e063 100%);
            position: sticky;
            top: 0;
            left: 0;
            z-index: 2000;
            min-height: 64px;
            box-shadow: 0 2px 12px #43a04722;
        }

        .encabezado {
            max-width: 100vw;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .encabezado .logo {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 2px 8px #a8e06333;
            object-fit: contain;
        }

        .encabezado .titulo {
            font-family: 'Segoe UI', sans-serif;
            font-size: 1.25rem;
            font-weight: bold;
            color: white;
            letter-spacing: 1px;
        }

        .encabezado .info-usuario {
            color: white;
            font-size: 0.875rem;
        }

        .btn-salir {
            border-radius: 1.2rem;
        }

        /* Ajuste para que el contenido no quede debajo del header */
        .main-content {
            margin-top: 56px !important;
        }

        /* Responsive para pantallas pequeñas */
        @media (max-width: 576px) {
            .encabezado {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .encabezado .titulo {
                font-size: 1rem;
            }

            .encabezado .info-usuario {
                font-size: 0.8rem;
            }

            .btn-salir {
                width: 100%;
                justify-content: center;
            }

            .main-content {
                margin-top: 64px !important;
            }
        }
    </style>
</head>
<body style="background-color: rgb(237, 241, 239);">

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!--  HEADER ADAPTABLE -->
<header class="shadow-sm mb-3">
    <div class="encabezado">
        <div class="d-flex align-items-center gap-2">
            <img src="logo.png" alt="Logo" class="logo">
            <span class="titulo">Sistema de Enfermería</span>
        </div>
        <div class="d-flex align-items-center gap-3 flex-wrap justify-content-end">
            <span class="info-usuario">
                <i class="bi bi-person-circle me-1"></i>
                <?= isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Invitado' ?>
                <span class="text-white-50">(<?= isset($_SESSION['cargo']) ? $_SESSION['cargo'] : 'No definido' ?>)</span>
            </span>
            <a href="cerrar_sesion.php" class="btn btn-outline-light btn-sm d-flex align-items-center gap-1 btn-salir">
                <i class="bi bi-box-arrow-right"></i> Salir
            </a>
        </div>
    </div>
</header>

</body>
</html>
