<?php
    session_start();
    include("conexion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rut = $_POST["rut"];
    $contrasena = $_POST["contrasena"];

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE rut = ?");
    $stmt->bind_param("s", $rut);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        if ($contrasena === $usuario["contrasena"]) {
            $_SESSION["id_usuario"] = $usuario["id"];
            $_SESSION["rol"] = $usuario["rol"];
            $_SESSION["nombre"] = $usuario["nombre_usuario"];

            if ($usuario["rol"] == "admin") {
                header("Location: vista_admin.php");
            } else {
                header("Location: vista_usuario.php");
            }
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
  }
  ?>






<!doctype html>
<html lang="es" class="dark">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="src/output.css">
  </head>
  <body>
  <main>
    <section class="py-36 flex items-center bg-gradient-to-r from-green-100 to-green-50 opacity-90 h-screen dark:from-slate-900 dark:to-slate-800">
      <div class="container mx-auto px-4">
        <div class="max-w-[400px] m-auto p-6 bg-white dark:bg-slate-950 shadow-md dark:shadow-gray-800 rounded-md">

          <div class="flex justify-center mb-6">
            <img src="src/INSIGNIA-LAV.png" alt="Insignia LAV" class="w-32 h-auto">
          </div>

          <h5 class="my-6 text-xl font-semibold text-black dark:text-white">
            Bienvenido
          </h5>

          <!-- Formulario de login -->
          <form id="loginForm" method="POST" action="">
            <div class="mb-4"> 
              <label for="rut" class="text-black dark:text-white">Usuario:</label>
              <input id="id_usuario" name="rut" type="text" required class="w-full mt-3 py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Ingresa tu rut" />
            </div>

            <div class="mb-4">
              <label for="Contrasena" class="text-black dark:text-white">Contraseña</label>
              <input id="Contrasena" name="contrasena" type="password" required class="mt-3 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Ingrese su Contraseña">
            </div>

            <div class="flex justify-between mb-4">
              <div class="flex items-center mb-0">
                <input class="rounded border-gray-200 dark:border-gray-800 text-green-600 mr-2" type="checkbox" id="Recordar" />
                <label class="text-slate-400" for="Recordar">Recordar</label>
              </div>
              <p class="text-slate-400 mb-0">
                <a href="auth-re-contraseña.html" class="text-slate-400">¿Olvidó su Contraseña?</a>
              </p>
            </div>

            <div class="mb-4">
              <input type="submit" value="Iniciar Sesión" class="py-2 px-5 inline-block tracking-wide border align-middle duration-500 text-base text-center bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md w-full" />
            </div>

          
          </form>

        </div>
      </div>
    </section>
  </main>
</body>

</html>



