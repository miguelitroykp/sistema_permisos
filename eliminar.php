<?php
include("conexion.php");

$id = $_GET['id'];
$sql ="DELETE FROM permisos_administrativos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("location: index.php?mensaje=eliminado");
} else {
    echo "error: " . $stmt->error;
}

?>
