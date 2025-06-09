<?php include("conexion.php"); 
$resultado = $conexion->query("SELECT * FROM permisos_administrativos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es" class="dark">
<head>
  <meta charset="UTF-8">
  <title>Lista de Permisos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="src/output.css">
</head>
<body class="bg-gradient-to-r from-green-100 to-green-50 dark:from-slate-900 dark:to-slate-800 min-h-screen text-gray-900 dark:text-white p-6">

  <div class="max-w-7xl mx-auto bg-white dark:bg-slate-950 shadow-lg rounded-lg p-6">

    <!-- Encabezado con botón de volver y nuevo permiso -->
    <div class="flex justify-between items-center mb-6">
      <div class="flex items-center space-x-4">
        <a href="vista_admin.php" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md text-sm font-semibold transition-colors">
          ← Volver
        </a>
        <h2 class="text-2xl font-semibold">Permisos Administrativos</h2>
      </div>
      <a href="crear.php" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-semibold transition-colors">Nuevo Permiso</a>
    </div>

    <!-- Alertas -->
    <?php if (isset($_GET['mensaje'])): ?>
      <?php if ($_GET['mensaje'] == 'guardado'): ?>
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Permiso guardado correctamente.</div>
      <?php elseif ($_GET['mensaje'] == 'eliminado'): ?>
        <div class="mb-4 p-4 rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Permiso eliminado correctamente.</div>
      <?php elseif ($_GET['mensaje'] == 'editado'): ?>
        <div class="mb-4 p-4 rounded bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Permiso editado correctamente.</div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Tabla -->
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm border-collapse border border-gray-200 dark:border-gray-700">
        <thead class="bg-green-600 text-white dark:bg-green-800">
          <tr>
            <th class="py-2 px-4 border">ID</th>
            <th class="py-2 px-4 border">Nombre</th>
            <th class="py-2 px-4 border">RUN</th>
            <th class="py-2 px-4 border">Desde</th>
            <th class="py-2 px-4 border">Hasta</th>
            <th class="py-2 px-4 border">Días</th>
            <th class="py-2 px-4 border">Motivo</th>
            <th class="py-2 px-4 border">Acciones</th>
          </tr>
        </thead>
        <tbody class="text-gray-800 dark:text-slate-300">
          <?php while ($row = $resultado->fetch_assoc()): ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
              <td class="py-2 px-4 border"><?= $row['id'] ?></td>
              <td class="py-2 px-4 border"><?= $row['nombre_completo'] ?></td>
              <td class="py-2 px-4 border"><?= $row['run'] ?></td>
              <td class="py-2 px-4 border"><?= $row['fecha_desde'] ?></td>
              <td class="py-2 px-4 border"><?= $row['fecha_hasta'] ?></td>
              <td class="py-2 px-4 border"><?= $row['numero_dias'] ?></td>
              <td class="py-2 px-4 border"><?= $row['motivo'] ?></td>
              <td class="py-2 px-4 border flex space-x-2">
                <a href="editar.php?id=<?= $row['id'] ?>" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs">Editar</a>
                <a href="eliminar.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este permiso?')" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Eliminar</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>

