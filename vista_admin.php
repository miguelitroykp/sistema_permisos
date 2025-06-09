<?php
session_start();
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: login.php");
    exit();
}

include("conexion.php");

// Paginación
$por_pagina = 5;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina > 1) ? ($pagina * $por_pagina) - $por_pagina : 0;

// Total de registros
$total_resultado = $conexion->query("SELECT COUNT(*) AS total FROM permisos_administrativos");
$total_filas = $total_resultado->fetch_assoc()['total'];
$total_paginas = ceil($total_filas / $por_pagina);

// Consulta limitada
$resultado = $conexion->query("SELECT * FROM permisos_administrativos ORDER BY fecha_solicitud DESC LIMIT $inicio, $por_pagina");
?>

<!doctype html>
<html lang="es" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Permisos Lav</title>
  <link rel="stylesheet" href="src/output.css">
</head>
<body class="text-gray-900 dark:text-white">
<section class="min-h-screen py-20 bg-gradient-to-r from-green-100 to-green-50 dark:from-slate-900 dark:to-slate-800">

<!-- Navbar -->
<nav class="fixed top-0 w-full z-50 bg-gradient-to-r from-green-100 to-green-50 dark:from-slate-900 dark:to-slate-800 border-b border-gray-300 dark:border-gray-700">
  <div class="container mx-auto flex items-center justify-between px-4 py-3">
    <div>
      <ul id="main-menu" class="hidden lg:flex lg:items-center lg:space-x-6 ml-6">
        <li><a href="crear.php?origen=admin" class="text-xs uppercase font-bold text-gray-900 dark:text-white hover:text-green-700 dark:hover:text-green-300">Crear Solicitud</a></li>
        <li><a href="index.php" class="text-xs uppercase font-bold text-gray-900 dark:text-white hover:text-green-700 dark:hover:text-green-300">Actualizar Permiso</a></li>
        <li><a href="crear_usuario.php" class="text-xs uppercase font-bold text-gray-900 dark:text-white hover:text-green-700 dark:hover:text-green-300">Crear Usuario</a></li>
        <li><a href="lista_usuarios.php" class="text-xs uppercase font-bold text-gray-900 dark:text-white hover:text-green-700 dark:hover:text-green-300">Lista de Usuarios</a></li>
        <li><a href="acerca_de.php" class="text-xs uppercase font-bold text-gray-900 dark:text-white hover:text-green-700 dark:hover:text-green-300">Diseñadores</a></li>
      </ul>
    </div>
    <div class="flex items-center space-x-4">
      <span class="text-sm font-semibold text-gray-900 dark:text-white">Admin: <?= $_SESSION['nombre'] ?></span>
      <button onclick="logout()" class="text-xs uppercase font-bold bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Cerrar Sesión</button>
    </div>
  </div>
</nav>

<!-- Tabla de permisos -->
<div class="pt-20 px-4">
  <table class="min-w-full text-sm border-collapse border border-gray-200 dark:border-gray-700">
   <thead class="bg-green-600 text-white dark:bg-green-800">
      <tr>
        <th class="px-4 py-3 border">Nombre</th>
        <th class="px-4 py-3 border">RUN</th>
        <th class="px-4 py-3 border">Motivo</th>
        <th class="px-4 py-3 border">Fecha de Solicitud</th>
        <th class="px-4 py-3 border">Desde</th>
        <th class="px-4 py-3 border">Hasta</th>
        <th class="px-4 py-3 border">Días Restantes</th>
        <th class="px-4 py-3 border">Estado</th>
        <th class="px-4 py-3 border">Acciones</th>
      </tr>
    </thead>
    <tbody class="bg-white dark:bg-slate-900">
      <?php while ($row = $resultado->fetch_assoc()): ?>
        <tr class="hover:bg-green-100 dark:hover:bg-slate-800 border-b border-gray-300 dark:border-gray-700">
          <td class="px-4 py-2 border"><?= htmlspecialchars($row["nombre_completo"]) ?></td>
          <td class="px-4 py-2 border"><?= htmlspecialchars($row["run"]) ?></td>
          <td class="px-4 py-2 border"><?= htmlspecialchars($row["motivo"]) ?></td>
          <td class="px-4 py-2 border"><?= htmlspecialchars($row["fecha_solicitud"]) ?></td>
          <td class="px-4 py-2 border"><?= htmlspecialchars($row["fecha_desde"]) ?></td>
          <td class="px-4 py-2 border"><?= htmlspecialchars($row["fecha_hasta"]) ?></td>

          <?php
            $dias_restantes = (strtotime($row["fecha_hasta"]) - strtotime(date("Y-m-d"))) / 86400;
            $dias_restantes = max(0, intval($dias_restantes));
          ?>
          <td class="px-4 py-2 border"><?= $dias_restantes ?> días</td>

          <?php
            $estado = $row["estado"];
            $clase_estado = match ($estado) {
              'pendiente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
              'aceptado'  => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
              default     => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100'
            };
          ?>
          <td class="px-4 py-2 border">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $clase_estado ?>">
              <?= ucfirst($estado) ?>
            </span>
          </td>

          <td class="px-4 py-2 border space-x-1">
            <?php if ($estado === "pendiente"): ?>
              <form action="actualizar_estado.php" method="POST" class="inline">
                <input type="hidden" name="id_permiso" value="<?= $row["id"] ?>">
                <input type="hidden" name="nuevo_estado" value="aceptado">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">Aceptar</button>
              </form>
              <form action="actualizar_estado.php" method="POST" class="inline">
                <input type="hidden" name="id_permiso" value="<?= $row["id"] ?>">
                <input type="hidden" name="nuevo_estado" value="rechazado">
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">Rechazar</button>
              </form>
            <?php else: ?>
              <span class="text-gray-500 text-xs">No editable</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Paginación -->
  <div class="mt-6 text-center space-x-2">
    <?php if ($pagina > 1): ?>
      <a href="?pagina=<?= $pagina - 1 ?>" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">← Anterior</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
      <a href="?pagina=<?= $i ?>" class="inline-block px-3 py-1 border rounded <?= $i === $pagina ? 'bg-blue-500 text-white' : 'bg-white text-blue-600 hover:bg-blue-100' ?>">
        <?= $i ?>
      </a>
    <?php endfor; ?>

    <?php if ($pagina < $total_paginas): ?>
      <a href="?pagina=<?= $pagina + 1 ?>" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Siguiente →</a>
    <?php endif; ?>
  </div>
</div>
</section>

<script>
  function logout() {
    window.location.href = 'login.php';
  }
</script>
</body>
</html>
