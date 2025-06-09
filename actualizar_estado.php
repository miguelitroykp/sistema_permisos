<?php
session_start();
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}

include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_permiso = intval($_POST["id_permiso"]);
    $nuevo_estado = $_POST["nuevo_estado"];

    if (in_array($nuevo_estado, ["aceptado", "rechazado"])) {
        $stmt = $conexion->prepare("UPDATE permisos_administrativos SET estado = ? WHERE id = ?");
        $stmt->bind_param("si", $nuevo_estado, $id_permiso);

        if ($stmt->execute()) {
            $_SESSION["mensaje"] = "Solicitud actualizada correctamente.";
        } else {
            $_SESSION["mensaje"] = "Error al actualizar.";
        }
    }
}

header("Location: vista_admin.php");
exit();
?>
