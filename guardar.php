<?php
include("conexion.php");
session_start();

// Activar errores para depuración (quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);
// 

// Verificar si el usuario está autenticado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $origen = $_GET["origen"] ?? "usuario";

    // Obtener datos del formulario
    $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
    $cargo_funcion = trim($_POST["cargo_funcion"] ?? '');
    $run = trim($_POST["run"] ?? '');
    $anios_servicio = (int)($_POST["anios_servicio"] ?? 0);
    $fecha_solicitud = $_POST["fecha_solicitud"] ?? '';
    $fecha_desde = $_POST["fecha_desde"] ?? '';
    $fecha_hasta = $_POST["fecha_hasta"] ?? '';
    $numero_dias = (int)($_POST["numero_dias"] ?? 0);
    $motivo = trim($_POST["motivo"] ?? '');
    $dias_restantes = is_numeric($_POST["dias_restantes"]) ? (int)$_POST["dias_restantes"] : 0;
    $detalle_motivo = trim($_POST["detalle_motivo"] ?? '');
    $fecha_autorizacion = $_POST["fecha_autorizacion"] ?? null;

    // Validación básica
    if (
        empty($id_usuario) || empty($run) || empty($fecha_solicitud) || empty($fecha_desde)
        || empty($fecha_hasta) || empty($motivo) || empty($cargo_funcion)
    ) {
        header("Location: crear.php?origen=$origen&error=faltan_datos");
        exit();
    }

    // Confirmar que el usuario existe y obtener su nombre
    $stmt_check = $conexion->prepare("SELECT nombre_usuario FROM usuarios WHERE id = ?");
    $stmt_check->bind_param("i", $id_usuario);
    $stmt_check->execute();
    $resultado = $stmt_check->get_result();

    // Verificar si el usuario existe
    if ($resultado->num_rows === 0) {
        header("Location: crear.php?origen=$origen&error=usuario_no_encontrado");
        exit();
    }

    $row = $resultado->fetch_assoc();
    $nombre_completo = $row['nombre_usuario'];

    // Valores por defecto para campos obligatorios adicionales
    $dias_ocupados = $numero_dias;
    $firma_encargado = "PENDIENTE";
    $estado = 'pendiente';

    // Insertar solicitud
    $stmt = $conexion->prepare("
        INSERT INTO permisos_administrativos (
            id_usuario, nombre_completo, fecha_solicitud, cargo_funcion, run,
            anios_servicio, fecha_desde, fecha_hasta, numero_dias, motivo,
            dias_ocupados, dias_restantes, firma_encargado, fecha_autorizacion, estado
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    // Vincular parámetros
    $stmt->bind_param(
        "issssissssiiiss",
        $id_usuario,
        $nombre_completo,
        $fecha_solicitud,
        $cargo_funcion,
        $run,
        $anios_servicio,
        $fecha_desde,
        $fecha_hasta,
        $numero_dias,
        $motivo,
        $dias_ocupados,
        $dias_restantes,
        $firma_encargado,
        $fecha_autorizacion,
        $estado
    );

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: " . ($origen === "admin" ? "vista_admin.php" : "vista_usuario.php") . "?mensaje=guardado");
        exit();
    } else {
        echo "❌ Error al ejecutar: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conexion->close();
}
