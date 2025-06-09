<?php
session_start();
include("conexion.php");

// Verificar si es admin
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Capturar términos de búsqueda
$busqueda = isset($_GET['busqueda']) ? $conexion->real_escape_string($_GET['busqueda']) : '';
$rol = isset($_GET['rol']) ? $conexion->real_escape_string($_GET['rol']) : '';

// Construir SQL con o sin filtros
$sql = "SELECT * FROM usuarios WHERE 1";

if (!empty($busqueda)) {
    $sql .= " AND (nombre_usuario LIKE '%$busqueda%' OR rut LIKE '%$busqueda%')";
}

if (!empty($rol)) {
    $sql .= " AND rol = '$rol'";
}

$sql .= " ORDER BY id ASC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es" class="dark">
<head>
  <meta charset="UTF-8">
  <title>Lista de Usuarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 dark:bg-slate-900 text-slate-900 dark:text-white min-h-screen py-10">

  <div class="container mx-auto px-4">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">
      <h2 class="text-2xl font-bold mb-6 text-center text-green-700 dark:text-green-400">
        Lista de Usuarios
      </h2>

      <?php if (isset($_GET["mensaje"])): ?>
        <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-800 border border-green-300 dark:bg-green-900 dark:text-green-200">
          <?= htmlspecialchars($_GET["mensaje"]) ?>
        </div>
      <?php endif; ?>

      <div class="flex justify-between items-center mb-4">
        <a href="crear_usuario.php" class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-md">
          Crear Nuevo Usuario
        </a>
        <a href="vista_admin.php" class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded-md">
          Volver
        </a>
      </div>

      <!-- Formulario de búsqueda y filtro por rol -->
      <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-3">
        <input
          type="text"
          name="busqueda"
          placeholder="Buscar por RUT o usuario"
          value="<?= htmlspecialchars($busqueda) ?>"
          class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-green-500 dark:bg-slate-700 dark:border-gray-600 dark:placeholder-gray-400"
        />

        <select name="rol" class="px-3 py-2 border border-gray-300 rounded-md dark:bg-slate-700 dark:border-gray-600 text-sm focus:outline-none focus:ring focus:border-green-500">
          <option value="">Seleccionar cargo</option>
          <option value="admin" <?= $rol === "admin" ? "selected" : "" ?>>Admin</option>
          <!--<option value="usuario" <?= $rol === "usuario" ? "selected" : "" ?>>Usuario</option> -->
          <option value="Administrativo" <?= $rol === "Administrativo"?"selected":""?>>Administrativo</option>
          <option value="asistente" <?= $rol === "asistente" ? "selected" : "" ?>>Asistente</option>
          <option value="auxiliar" <?= $rol === "auxiliar" ? "selected" : "" ?>>Auxiliar</option>
          <option value="profesor (a)" <?= $rol === "profesor (a)" ? "selected" : "" ?>>Profesor(a)</option>
          <option value="Apoyo Curricular" <?= $rol === "Apoyo Curricular"?"selected":""?>>Apoyo Curricular</option>
          <option value="Asistente de aula" <?= $rol === "Asistente de aula"?"selected":""?>>Asistente de aula</option>
          <option value="Asistente Pie" <?= $rol === "Asistente Pie"?"selected":""?>>Asistente Pie</option>
          <option value="Asistente Profesional" <?= $rol === "Asistente Profesional"?"selected":""?>>Asistente Profesional</option>
          <option value="Asistente Social" <?= $rol === "Asistente Social"?"selected":""?>>Asistente Social</option>
          <option value="Auxiliar de aseo" <?= $rol === "Auxiliar de aseo"?"selcted":""?>>Auxiliar de aseo</option>
          <option value="Bibliotecaria" <?= $rol === "Bibliotecaria"?"selected":""?>>Bibliotecaria</option>
          <option value="Encargada certificados" <?= $rol === "Encargada certificados"?"selected":""?>>Encargada certificados</option>
          <option value="Encargada fotocopias" <?= $rol === "Encargada fotocopias"?"selected":""?>>Encargada fotocopias</option>
          <option value="Encargada sige" <?= $rol === "Encargada sige"?"selected":""?>>Encargada sige</option>
          <option value="Encargada Pae" <?= $rol === "Encargada pae"?"selected":""?>>Encargada Pae</option>
          <option value="Encargado Aula magna" <?= $rol === "Encargado Aula magna"?"selected":""?>>Encargado Aula magna</option>
          <option value="Encargado Bodega" <?= $rol === "Encargado Bodega"?"selected":""?>>Encargado Bodega</option>
          <option value="Encargado Cultural" <?= $rol === "Encargado Cultural"?"selected":""?>>Encargado Cultural</option>
          <option value="Enfermero" <?= $rol === "Enfermero"?"selected":""?>>Enfermero</option>
          <option value="Fonoaudiologa" <?= $rol === "Fonoaudiologa"?"selected":""?>>Fonoaudiologa</option>
          <option value="Inspector (a)" <?= $rol === "Inspector (a)"?"selected":""?>>Inspector (a)</option>
          <option value="Justificativo Básica" <?= $rol === "Justificativo Basica"?"selected":""?>>Justificativo Básica</option>
          <option value="Justificativo Media" <?= $rol === "Justificativo Media"?"selected":""?>>Justificativo Media</option>
          <option value="Kinesiólogo (a)" <?= $rol === "Kinesiólogo (a)"?"selected":""?>>Kinesiólogo (a)</option>
          <option value="Parvularia" <?= $rol === "Parvularia"?"selected":""?>>Parvularia</option>
          <option value="Prevencionista de Riesgos" <?= $rol === "Prevencionista de Riesgos"?"selected":""?>>Prevencionista de Riesgos</option>
          <option value="Psicólogo" <?= $rol === "Psicólogo"?"selected":""?>>Psicólogo</option>
          <option value="Psicopedagoga" <?= $rol === "Psicopedagoga"?"selected":""?>>Psicopedagoga</option>
          <option value="Secretaria" <?= $rol === "Secretaria"?"selected":""?>>Secretaria</option>
          <option value="Soporte Informático" <?= $rol === "Soporte Informático"?"selected":""?>>Soporte Informático</option>
          <option value="Técnico Social" <?= $rol === "Técnico Social"?"selected":""?>>Técnico Social</option>
          <option value="TENS" <?= $rol === "TENS"?"selected":""?>>TENS</option>
          <option value="Trabajador (a) Social" <?= $rol === ""?"":""?>>Trabajador Social (a)</option>
        </select>

        <button
          type="submit"
          class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors"
        >
          Buscar
        </button>
      </form>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-green-200 dark:bg-slate-700 text-left">
            <tr>
              <th class="px-4 py-3 text-xs font-semibold uppercase">ID</th>
              <th class="px-4 py-3 text-xs font-semibold uppercase">Usuario</th>
              <th class="px-4 py-3 text-xs font-semibold uppercase">RUT</th>
              <th class="px-4 py-3 text-xs font-semibold uppercase">Rol</th>
              <th class="px-4 py-3 text-xs font-semibold uppercase">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php while ($usuario = $resultado->fetch_assoc()): ?>
              <tr class="hover:bg-green-50 dark:hover:bg-slate-700">
                <td class="px-4 py-2"><?= $usuario["id"] ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($usuario["nombre_usuario"]) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($usuario["rut"]) ?></td>
                <td class="px-4 py-2 capitalize"><?= htmlspecialchars($usuario["rol"]) ?></td>
                <td class="px-4 py-2 space-x-2">
                  
                  <a href="ver.php?id=<?= $usuario["id"] ?>" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Ver
                  </a>

                  <a href="editar_usuario.php?id=<?= $usuario["id"] ?>" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded">
                    Editar
                  </a>
                  <a href="eliminar_usuario.php?id=<?= $usuario["id"] ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?');" class="inline-block bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                    Eliminar
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>
</html>
