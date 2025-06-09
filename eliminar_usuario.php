<?php
include("conexion.php");

if (!isset($_GET["id"])) {
    header("Location: lista_usuarios.php");
    exit();
}

$id = $_GET["id"];

$stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: lista_usuarios.php?mensaje=eliminado");
} else {
    echo "Error: " . $stmt->error;
}
?>
