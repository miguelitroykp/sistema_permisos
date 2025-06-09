<?php
include("conexion.php");

$id = $_GET['id'];
$sql = "SELECT * FROM permisos_administrativos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$row = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_solicitud = $_POST["fecha_solicitud"];
    $nombre_completo = $_POST["nombre_completo"];
    $cargo_funcion = $_POST["cargo_funcion"];
    $run = $_POST["run"];
    $anios_servicio = $_POST["anios_servicio"];
    $fecha_desde = $_POST["fecha_desde"];
    $fecha_hasta = $_POST["fecha_hasta"];
    $numero_dias = $_POST["numero_dias"];
    $motivo = $_POST["motivo"];
    //$dias_ocupados = $_POST["dias_ocupados"];
    $dias_restantes = $_POST["dias_restantes"];
    //$firma_encargado = $_POST["firma_encargado"];
    $fecha_autorizacion = $_POST["fecha_autorizacion"];

    $sql = "UPDATE permisos_administrativos SET 
        fecha_solicitud=?, nombre_completo=?, cargo_funcion=?, run=?, anios_servicio=?, 
        fecha_desde=?, fecha_hasta=?, numero_dias=?, motivo=?, dias_ocupados=?, 
        dias_restantes=?, firma_encargado=?, fecha_autorizacion=?
        WHERE id=?";
        
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssissisisssi", 
        $fecha_solicitud, $nombre_completo, $cargo_funcion,
        $run, $anios_servicio, $fecha_desde, $fecha_hasta, $numero_dias,
        $motivo, $dias_ocupados, $dias_restantes, $firma_encargado,
        $fecha_autorizacion, $id
    );

    if ($stmt->execute()) {
        header("Location: index.php?mensaje=editado");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es" class="dark">
<head>
  <meta charset="UTF-8">
  <title>Editar Permiso</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="src/output.css">
</head>
<body>
  <section class="min-h-screen py-20 bg-gradient-to-r from-green-100 to-green-50 dark:from-slate-900 dark:to-slate-800">
    <div class="max-w-md mx-auto p-6 bg-white dark:bg-slate-950 shadow-md rounded-lg">
        <h2 class="text-xl font-semibold text-center mb-6 dark:text-white">Editar solicitud</h2>

      <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block mb-1  dark:text-white">Fecha Solicitud</label>
          <input type="date" name="fecha_solicitud" value="<?= $row['fecha_solicitud'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div>
          <label class="block mb-1  dark:text-white">Nombre Completo</label>
          <input type="text" name="nombre_completo" value="<?= $row['nombre_completo'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div>
          <label class="block mb-1  dark:text-white">Cargo / Función</label>
          <input type="text" name="cargo_funcion" value="<?= $row['cargo_funcion'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div>
          <label class="block mb-1  dark:text-white">RUN</label>
          <input type="text" name="run" value="<?= $row['run'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div>
          <label class="block mb-1  dark:text-white">Años de Servicio</label>
          <input type="number" name="anios_servicio" value="<?= $row['anios_servicio'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div>
          <label class="block mb-1  dark:text-white">Fecha Desde</label>
          <input type="date" name="fecha_desde" value="<?= $row['fecha_desde'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div>
          <label class="block mb-1  dark:text-white">Fecha Hasta</label>
          <input type="date" name="fecha_hasta" value="<?= $row['fecha_hasta'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div>
          <label class="block mb-1  dark:text-white">N° de Días</label>
          <input type="number" name="numero_dias" value="<?= $row['numero_dias'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div class="md:col-span-2  dark:text-white">
          <label class="block mb-1">Motivo</label>
          <textarea name="motivo" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900"><?= $row['motivo'] ?></textarea>
        </div>

        <div>
          <label class="block mb-1 dark:text-white">Días Ocupados</label>
          <input type="number" name="dias_ocupados" value="<?= $row['dias_ocupados'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div>
          <label class="block mb-1 dark:text-white">Días Restantes</label>
          <input type="number" name="dias_restantes" value="<?= $row['dias_restantes'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div>
          <label class="block mb-1 dark:text-white">Firma Encargado</label>
          <input type="text" name="firma_encargado" value="<?= $row['firma_encargado'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div>
          <label class="block mb-1 dark:text-white">Fecha Autorización</label>
          <input type="date" name="fecha_autorizacion" value="<?= $row['fecha_autorizacion'] ?>" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white">
        </div>

        <div class="md:col-span-2 flex justify-between mt-6">
          <a href="index.php" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md">Cancelar</a>
          <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Actualizar Permiso</button>
        </div>
      </form>
    </div>
  </section>
</body>
</html>
