<?php 
include("conexion.php"); 
$resultado = $conexion->query("SELECT * FROM permisos_administrativos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es" class="dark">
<head>
  <meta charset="UTF-8">
  <title>Vista Usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 dark:bg-slate-900 text-gray-900 dark:text-white min-h-screen py-10 px-4">

  <div class="max-w-7xl mx-auto bg-white dark:bg-slate-800 p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-center text-green-700 dark:text-green-400 mb-6">Permisos Administrativos</h1>

    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-left divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-green-100 dark:bg-slate-700 text-gray-800 dark:text-white">
          <tr>
            <th class="px-4 py-2">Nombre</th>
            <th class="px-4 py-2">RUN</th>
            <th class="px-4 py-2">Desde</th>
            <th class="px-4 py-2">Hasta</th>
            <th class="px-4 py-2">Días</th>
            <th class="px-4 py-2">Motivo</th>
            <th class="px-4 py-2">Estado</th>
           <!-- <th class="px-4 py-2">Acciones</th>-->
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-600">
          <?php while ($row = $resultado->fetch_assoc()): ?>
            <?php
              $estado = $row['estado'] ?? 'Pendiente';
              $claseEstado = match ($estado) {
                'Aprobado'  => 'bg-green-200 text-green-800 dark:bg-green-700 dark:text-white',
                'Rechazado' => 'bg-red-200 text-red-800 dark:bg-red-700 dark:text-white',
                default     => 'bg-yellow-200 text-yellow-800 dark:bg-yellow-600 dark:text-white',
              };
            ?>
            <tr class="hover:bg-green-50 dark:hover:bg-slate-700">
              <td class="px-4 py-2"><?= htmlspecialchars($row['nombre_completo']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['run']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['fecha_desde']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['fecha_hasta']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['numero_dias']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['motivo']) ?></td>
              <td class="px-4 py-2">
                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold <?= $claseEstado ?>">
                 <?= htmlspecialchars($estado) ?> 
                </span>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
