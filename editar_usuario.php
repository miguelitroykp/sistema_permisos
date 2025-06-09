<?php
include("conexion.php");

if (!isset($_GET["id"])) {
    header("Location: lista_usuarios.php");
    exit();
}

$id = $_GET["id"];

$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre_usuario"];
    $rut = $_POST["rut"];
    $rol = $_POST["rol"];
    $contrasena = $_POST["contrasena"];

    if (!empty($contrasena)) {
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre_usuario=?, rut=?, contrasena=?, rol=? WHERE id=?");
        $stmt->bind_param("ssssi", $nombre, $rut, $contrasena, $rol, $id);
    } else {
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre_usuario=?, rut=?, rol=? WHERE id=?");
        $stmt->bind_param("sssi", $nombre, $rut, $rol, $id);
    }

    if ($stmt->execute()) {
        header("Location: lista_usuarios.php?mensaje=editado");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="es" class="dark">
<head>
  <meta charset="UTF-8">
  <title>Editar Usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 dark:bg-slate-900 text-slate-900 dark:text-white min-h-screen py-10">

  <div class="container mx-auto max-w-xl px-4">
    <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold mb-6 text-center text-green-700 dark:text-green-400">Editar Usuario</h2>

      <form method="POST" class="space-y-4">
        <div>
          <label class="block mb-1 font-semibold">Nombre de Usuario</label>
          <input type="text" name="nombre_usuario" value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" required
                 class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white focus:ring-2 focus:ring-green-400 focus:outline-none">
        </div>

        <div>
          <label class="block mb-1 font-semibold">RUT</label>
          <input type="text" name="rut" value="<?= htmlspecialchars($usuario['rut']) ?>" required
                 class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white focus:ring-2 focus:ring-green-400 focus:outline-none">
        </div>

        <div>
          <label class="block mb-1 font-semibold">Nueva Contraseña (opcional)</label>
          <input type="password" name="contrasena"
                 class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white focus:ring-2 focus:ring-green-400 focus:outline-none">
        </div>

        <div>
          <label class="block mb-1 font-semibold">Rol</label>
          <select name="rol"
                  class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white focus:ring-2 focus:ring-green-400 focus:outline-none">
            <option value="usuario" <?= $usuario['rol'] == 'usuario' ? 'selected' : '' ?>>Usuario</option>
            <option value="admin" <?= $usuario['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
            <option value="auxiliar" <?= $usuario['rol'] == 'auxiliar' ? 'selected' : '' ?>>Auxiliar</option>
            <option value="asistente" <?= $usuario['rol'] == 'asistente' ? 'selected' : '' ?>>Asistente</option>
            <option value="profesor(a)" <?= $usuario['rol'] == 'Profesor(a)' ? 'selected' : '' ?>>Profesor(a)</option>
          </select>
        </div>

        <div class="flex justify-between">
          <button type="submit"
                  class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-md">
            Actualizar
          </button>
          <a href="lista_usuarios.php"
             class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-md">
            Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
