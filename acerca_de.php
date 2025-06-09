<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Acerca del Sistema</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-r from-blue-50 to-green-100 dark:from-slate-900 dark:to-slate-800 min-h-screen flex items-center justify-center p-6 text-slate-800 dark:text-white">

  <div class="bg-white dark:bg-slate-800 shadow-2xl rounded-3xl max-w-3xl w-full px-10 py-12">
    <h1 class="text-4xl font-extrabold text-center text-blue-700 dark:text-blue-400 mb-10">Acerca del Sistema</h1>

    <div class="space-y-5 text-lg">
      <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M12 6V4m0 2v2m0 4v2m0-2v-2m0 6v2m0-2v-2m-6 0h2m-2 0H4m16 0h-2m2 0h2M5.636 18.364l1.414-1.414m-1.414 1.414l-1.414 1.414M18.364 5.636l-1.414 1.414m1.414-1.414l1.414-1.414" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p><strong>Nombre del sistema:</strong> Sistema de Permisos Administrativos</p>
      </div>

      <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M8 16h8m-4-12v12m4 8H8a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v14a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p><strong>Descripción:</strong> Permite a los usuarios solicitar permisos administrativos como días administrativos, medios días o licencias médicas.</p>
      </div>

      <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p><strong>Desarrollado por:</strong> Rubén Arancibia Muñoz Jesús, Miguel Ignacio Jesús Alvarez</p>
      </div>

      <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p><strong>Institución:</strong> CFT San Agustín</p>
      </div>

      <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M3 7l9 6 9-6v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p><strong>Proyecto realizado para:</strong> Liceo Antonio Varas</p>
      </div>

      <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p><strong>Fecha:</strong> <?= date("Y") ?></p>
      </div>

      <div class="pt-4">
        <h3 class="font-semibold mb-2 text-blue-600 dark:text-blue-300">🛠 Tecnologías utilizadas:</h3>
        <ul class="list-disc list-inside space-y-1 text-base text-gray-700 dark:text-gray-200">
          <li><strong>Frontend:</strong> HTML, Google Fonts, Tailwind CSS</li>
          <li><strong>Backend:</strong> PHP (sin framework)</li>
          <li><strong>Base de Datos:</strong> MySQL (phpMyAdmin)</li>
        </ul>
      </div>
      
      <div class="mt-8 text-center">
        <a href="vista_admin.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
          ← Volver a Panel de Administración
        </a>
      </div>

    </div>
  </div>

</body>
</html>
