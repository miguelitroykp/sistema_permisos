<?php
include("conexion.php");

$searchTerm = $_POST['term'] ?? '';

// Prepara la consulta con LIKE para evitar inyección SQL
$stmt = $conexion->prepare("SELECT id, nombre_usuario, rut FROM usuarios WHERE nombre_usuario LIKE ?");
$param = "%".$searchTerm."%";
$stmt->bind_param("s", $param);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        "id" => $row["id"],
        "text" => $row["nombre_usuario"], // 'text' es necesario para Select2
        "rut" => $row["rut"]
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
