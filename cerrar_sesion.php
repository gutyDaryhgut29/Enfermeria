<?php
session_start();         // Inicia sesión
session_unset();         // Borra todas las variables de sesión
session_destroy();       // Destruye la sesión

// Redirige al iniciar sesion
header("Location: iniciar_sesion.php");
exit;
