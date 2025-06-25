<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: lista_usuarios.php?mensaje=id_invalido");
    exit();
}

$id_usuario = intval($_GET["id"]);

// Obtener datos del usuario
$sql_usuario = "SELECT * FROM usuarios WHERE id = ?";
$stmt_usuario = $conexion->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $id_usuario);
$stmt_usuario->execute();
$resultado_usuario = $stmt_usuario->get_result();

if ($resultado_usuario->num_rows === 0) {
    header("Location: lista_usuarios.php?mensaje=usuario_no_encontrado");
    exit();
}

$usuario = $resultado_usuario->fetch_assoc();
$imagenDefault = "img/avatar-default.png";
$fotoPath = (!empty($usuario["foto"]) && file_exists($usuario["foto"])) ? $usuario["foto"] : $imagenDefault;

// Obtener permisos del usuario
$sql_permisos = "SELECT * FROM permisos_administrativos WHERE id_usuario = ? ORDER BY fecha_solicitud DESC";
$stmt_permisos = $conexion->prepare($sql_permisos);
$stmt_permisos->bind_param("i", $id_usuario);
$stmt_permisos->execute();
$resultado_permisos = $stmt_permisos->get_result();

// Calcular resumen de permisos
$resumen = [
    'total_dias' => 0,
    'aceptados' => 0,
    'rechazados' => 0,
    'pendientes' => 0
];

if ($resultado_permisos && $resultado_permisos->num_rows > 0) {
    $resultado_permisos->data_seek(0);
    while ($permiso = $resultado_permisos->fetch_assoc()) {
        $resumen['total_dias'] += (int)$permiso['numero_dias'];
        switch (strtolower(trim($permiso['estado']))) {
            case 'aceptado':
                $resumen['aceptados']++;
                break;
            case 'rechazado':
                $resumen['rechazados']++;
                break;
            default:
                $resumen['pendientes']++;
                break;
        }
    }
    $resultado_permisos->data_seek(0); // Reiniciar puntero para mostrar en tabla
}
?>

<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-green-50 dark:bg-slate-900 text-gray-900 dark:text-white min-h-screen py-10 px-4">
    <div class="max-w-6xl mx-auto">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 bg-white dark:bg-slate-800 p-4 rounded shadow">
            <h1 class="text-2xl font-semibold text-green-700 dark:text-green-400 flex items-center gap-2">
                <i class="bi bi-person-circle"></i> Detalles del Usuario
            </h1>
            <a href="lista_usuarios.php" class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                <i class="bi bi-arrow-left-circle"></i> Volver
            </a>
        </div>


        <!-- Resumen -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300 p-4 rounded-lg shadow text-center">
                <i class="bi bi-calendar-check text-xl"></i>
                <div class="text-sm mt-1">Total días</div>
                <div class="text-2xl font-bold"><?= $resumen['total_dias'] ?? 0 ?></div>
            </div>
            <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 p-4 rounded-lg shadow text-center">
                <i class="bi bi-check-circle text-xl"></i>
                <div class="text-sm mt-1">Aceptados</div>
                <div class="text-2xl font-bold"><?= $resumen['aceptados'] ?? 0 ?></div>
            </div>
            <div class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300 p-4 rounded-lg shadow text-center">
                <i class="bi bi-x-circle text-xl"></i>
                <div class="text-sm mt-1">Rechazados</div>
                <div class="text-2xl font-bold"><?= $resumen['rechazados'] ?? 0 ?></div>
            </div>
            <div class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 p-4 rounded-lg shadow text-center">
                <i class="bi bi-hourglass-split text-xl"></i>
                <div class="text-sm mt-1">Pendientes</div>
                <div class="text-2xl font-bold"><?= $resumen['pendientes'] ?? 0 ?></div>
            </div>
        </div>

        <!-- Historial de permisos -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-green-700 dark:text-green-400 flex items-center gap-2 mb-4">
                <i class="bi bi-clipboard-check"></i> Historial de Permisos
            </h3>

            <?php if ($resultado_permisos->num_rows > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-green-100 dark:bg-slate-700 text-gray-800 dark:text-white">
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Solicitud</th>
                                <th class="px-4 py-2">Desde</th>
                                <th class="px-4 py-2">Hasta</th>
                                <th class="px-4 py-2">Días</th>
                                <th class="px-4 py-2">Motivo</th>
                                <th class="px-4 py-2">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-600">
                        <?php while ($permiso = $resultado_permisos->fetch_assoc()): ?>
                            <?php
                                $estado = strtolower($permiso["estado"]);
                                $clase = match($estado) {
                                    "aceptado" => "bg-green-200 text-green-800 dark:bg-green-700 dark:text-white",
                                    "rechazado" => "bg-red-200 text-red-800 dark:bg-red-700 dark:text-white",
                                    default => "bg-yellow-200 text-yellow-800 dark:bg-yellow-600 dark:text-white"
                                };
                            ?>
                            <tr class="hover:bg-green-50 dark:hover:bg-slate-700">
                                <td class="px-4 py-2"><?= $permiso["id"] ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($permiso["fecha_solicitud"]) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($permiso["fecha_desde"]) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($permiso["fecha_hasta"]) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($permiso["numero_dias"]) ?></td>
                                <td class="px-4 py-2"><?= substr(htmlspecialchars($permiso["motivo"]), 0, 40) ?>...</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold <?= $clase ?>">
                                        <?= ucfirst($estado) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-gray-500 dark:text-gray-400 text-sm">Este usuario no tiene permisos registrados.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
