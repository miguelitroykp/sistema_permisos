<?php
session_start();

// Limpiar todas las variables de sesión
$_SESSION = array();

// Destruir la sesión completamente
session_destroy();

// Redireccionar al login y terminar el script
header("Location: login.php");
exit;
?>