<?php
include("conexion.php");
session_start();

// Verificar que solo un administrador pueda acceder
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: vista_admin.php");
    exit();
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST["nombre_usuario"];
    $rut = $_POST["rut"];
    $contrasena = $_POST["contrasena"];
    $rol = $_POST["rol"];

    $sql = "INSERT INTO usuarios (nombre_usuario, rut, contrasena, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $nombre_usuario, $rut, $contrasena, $rol);

    if ($stmt->execute()) {
        $mensaje = "Usuario creado exitosamente.";
    } else {
        $mensaje = "Error al crear el usuario: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es" class="dark">
<head>
  <meta charset="UTF-8">
  <title>Crear Usuario</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-r from-green-100 to-green-50 dark:from-slate-900 dark:to-slate-800 px-4">

  <div class="bg-white dark:bg-slate-950 p-8 rounded-lg shadow-lg max-w-md w-full">
    <h2 class="text-2xl font-semibold mb-6 text-center dark:text-white">Crear Nuevo Usuario</h2>

    <?php if (isset($mensaje)) : ?>
      <div class="mb-4 p-3 bg-blue-100 border border-blue-300 text-blue-700 rounded">
        <?= $mensaje ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-4">
        <label class="block mb-1 text-sm dark:text-white">Nombre de Usuario</label>
        <input type="text" name="nombre_usuario" class="w-full px-3 py-2 border rounded-md dark:bg-slate-900 dark:border-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>

      <div class="mb-4">
        <label class="block mb-1 text-sm dark:text-white">RUT</label>
        <input type="text" name="rut" class="w-full px-3 py-2 border rounded-md dark:bg-slate-900 dark:border-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>

      <div class="mb-4">
        <label class="block mb-1 text-sm dark:text-white">Contraseña</label>
        <input type="password" name="contrasena" class="w-full px-3 py-2 border rounded-md dark:bg-slate-900 dark:border-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>

      <div class="mb-6">
        <label class="block mb-1 text-sm dark:text-white">Rol</label>
        <select name="rol" class="w-full px-3 py-2 border rounded-md dark:bg-slate-900 dark:border-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500" required>
          <!--<option value="usuario">Usuario</option>-->
          <option value="admin">Administrador</option>
          <option value="auxiliar">Auxiliar</option>
          <option value="asistente">Asistente</option>
          <option value="profesor(a)">Profesor(a)</option>
          <option value="">Administrativo</option>
          <option value="">>Asistente</option>
          <option value="">Auxiliar</option>
          <option value="">Profesor(a)</option>
          <option value="">Apoyo Curricular</option>
          <option value="">Asistente de aula</option>
          <option value="">Asistente Pie</option>
          <option value="">Asistente Profesional</option>
          <option value="">Asistente Social</option>
          <option value="">Auxiliar de aseo</option>
          <option value="">Bibliotecaria</option>
          <option value="">Encargada certificados</option>
          <option value="">Encargada fotocopias</option>
          <option value="">Encargada sige</option>
          <option value="">Encargada Pae</option>
          <option value="">Encargado Aula magna</option>
          <option value="">Encargado Bodega</option>
          <option value="">Encargado Cultural</option>
          <option value="">Enfermero</option>
          <option value="">Fonoaudiologa</option>
          <option value="">Inspector (a)</option>
          <option value="">Justificativo Básica</option>
          <option value="">ustificativo Media</option>
          <option value="">Kinesiólogo (a)</option>
          <option value="">Parvularia</option>
          <option value="">Prevencionista de Riesgos</option>
          <option value="">Psicólogo</option>
          <option value="">Psicopedagoga</option>
          <option value="">Secretaria</option>
          <option value="">Soporte Informático</option>
          <option value="">Técnico Social</option>
          <option value="">TENS</option>
          <option value="">Trabajador Social (a)</option>
        </select>
      </div>

      <div class="flex justify-between">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-md">Crear Usuario</button>
        <a href="vista_admin.php" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-md">Volver</a>
      </div>
    </form>
  </div>

</body>
</html>
