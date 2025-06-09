<?php
include("conexion.php");
session_start();
$origen = $_GET['origen'] ?? 'admin';

$usuarioSeleccionadoId = '';
$usuarioSeleccionadoNombre = '';
$usuarioSeleccionadoRut = '';

if ($origen === 'usuario' && isset($_SESSION['id_usuario'])) {
    $usuarioSeleccionadoId = $_SESSION['id_usuario'];

    $stmt = $conexion->prepare("SELECT nombre_usuario, rut FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuarioSeleccionadoId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $usuarioSeleccionadoNombre = $row['nombre_usuario'];
        $usuarioSeleccionadoRut = $row['rut'];
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nuevo Permiso Administrativo</title>
  <link rel="stylesheet" href="src/output.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <style>
    .select2-container--default .select2-selection--single {
      height: 40px;
      padding-top: 5px;
      border: 1px solid #d1d5db;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 38px;
    }
  </style>
</head>
<body>

  <section class="min-h-screen py-20 bg-gradient-to-r from-green-100 to-green-50 dark:from-slate-900 dark:to-slate-800">
    <div class="max-w-md mx-auto p-6 bg-white dark:bg-slate-950 shadow-md rounded-lg">
      <h2 class="text-xl font-semibold text-center mb-6 dark:text-white">Crear Solicitud</h2>

      <form action="guardar.php?origen=<?= $origen ?>" method="POST">
        <?php if (!empty($usuarioSeleccionadoId)) : ?>
          <input type="hidden" name="id_usuario" value="<?= $usuarioSeleccionadoId ?>">
        <?php endif; ?>

       <div class="mb-4">
          <label class="block text-sm dark:text-white">Nombre Completo</label>
  
          <?php if ($origen === 'usuario' && !empty($usuarioSeleccionadoId)) : ?>
            <!-- Solo muestra el nombre, y pasa el ID en hidden -->
            <input type="hidden" name="id_usuario" value="<?= $usuarioSeleccionadoId ?>">
            <input type="text" value="<?= $usuarioSeleccionadoNombre ?>" readonly class="w-full h-10 px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 bg-gray-100 cursor-not-allowed" />
          <?php else : ?>
            <!-- Solo si origen es admin, muestra el select2 -->
            <select id="nombre_completo" name="id_usuario" class="w-full px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:border-green-600 focus:outline-none" required>
              <?php if (!empty($usuarioSeleccionadoId) && !empty($usuarioSeleccionadoNombre)) : ?>
                <option value="<?= $usuarioSeleccionadoId ?>" selected><?= $usuarioSeleccionadoNombre ?></option>
              <?php endif; ?>
            </select>
          <?php endif; ?>
        </div>

        <div class="mb-4">
          <label class="block text-sm dark:text-white">RUT</label>
          <input type="text" name="run" class="w-full h-10 px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:border-green-600 focus:outline-none" value="<?= $usuarioSeleccionadoRut ?? '' ?>" placeholder="Ej: 12345678-9" required readonly />
        </div>

        <?php $fechaHoy = date('Y-m-d'); ?>
          <div class="mb-4">
            <label class="block text-sm dark:text-white">Fecha de Solicitud</label>
            <input type="date" name="fecha_solicitud" value="<?= $fechaHoy ?>" readonly class="w-full h-10 px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:outline-none cursor-not-allowed bg-gray-100 dark:cursor-not-allowed" />
          </div>


        <div class="mb-4">
          <label class="block text-sm dark:text-white">Tipo de Solicitud</label>
          <select id="tipoSolicitud" name="motivo" class="w-full h-10 px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:border-green-600 focus:outline-none" required>
            <option value="">Seleccionar</option>
            <option value="permisomedico">Licencia Médica</option>
            <option value="Dia_administrativo">Día Administrativo</option>
            <option value="Medio_dia">Medio Día</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-sm dark:text-white">Seleccionar Cargo</label>
          <select name="cargo_funcion" class="w-full h-10 px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:border-green-600 focus:outline-none" required>
            <option value="">Cargo</option>
            <option value="Profesor">Profesor</option>
            <option value="Auxiliar">Auxiliar</option>
            <option value="Inspector">Inspector</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-sm dark:text-white">Años de Servicio</label>
          <input type="number" name="anios_servicio" class="w-full h-10 px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:border-green-600 focus:outline-none" required />
        </div>

        <div class="mb-4">
          <label class="block text-sm dark:text-white">Fecha Inicio</label>
          <input type="date" name="fecha_desde" id="fecha_desde" class="w-full h-10 px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:border-green-600 focus:outline-none" required />
        </div>

        <div class="mb-4">
          <label class="block text-sm dark:text-white">Fecha Fin</label>
          <input type="date" name="fecha_hasta" id="fecha_hasta" class="w-full h-10 px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:border-green-600 focus:outline-none" required />
        </div>

        <div id="numeroDiasDiv" class="mb-4">
          <label class="block text-sm dark:text-white">Número de Días</label>
          <input type="number" name="numero_dias" id="numero_dias" class="w-full h-10 px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:border-green-600 focus:outline-none" />
        </div>

        <div id="diasRestantesDiv" class="mb-4">
          <label class="block text-sm dark:text-white">Días Restantes</label>
          <input type="number" name="dias_restantes" id="dias_restantes" class="w-full h-10 px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:border-green-600 focus:outline-none" />
        </div>

        <div class="mb-4">
          <label class="block text-sm dark:text-white">Fecha de Autorización</label>
          <input type="date" name="fecha_autorizacion" class="w-full h-10 px-3 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:border-green-600 focus:outline-none" />
        </div>

        <div class="mb-4">
          <label class="block text-sm dark:text-white">Motivo (Detalles)</label>
          <textarea name="detalle_motivo" class="w-full px-3 py-2 rounded border dark:bg-slate-900 dark:text-white border-gray-300 dark:border-gray-800 focus:border-green-600 focus:outline-none" rows="3" placeholder="Escribe el motivo..." required></textarea>
        </div>

        <div class="flex justify-between mt-4">
          <a href="<?= $origen === 'usuario' ? 'vista_usuario.php' : 'vista_admin.php' ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            Volver
          </a>
          <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Enviar Solicitud
          </button>
        </div>
      </form>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const tipoSolicitud = document.getElementById('tipoSolicitud');
      const numeroDiasDiv = document.getElementById('numeroDiasDiv');
      const diasRestantesDiv = document.getElementById('diasRestantesDiv');
      const numeroDiasInput = document.getElementById('numero_dias');
      const diasRestantesInput = document.getElementById('dias_restantes');

      function actualizarCampos() {
        const valor = tipoSolicitud.value;
        if (valor === 'permisomedico') {
          numeroDiasDiv.style.display = 'block';
          numeroDiasInput.required = true;
          diasRestantesDiv.style.display = 'none';
          diasRestantesInput.required = false;
          diasRestantesInput.value = '';
        } else if (valor === 'Dia_administrativo') {
          numeroDiasDiv.style.display = 'block';
          diasRestantesDiv.style.display = 'block';
          numeroDiasInput.required = true;
          diasRestantesInput.required = true;
        } else {
          numeroDiasDiv.style.display = 'none';
          diasRestantesDiv.style.display = 'none';
          numeroDiasInput.required = false;
          diasRestantesInput.required = false;
          numeroDiasInput.value = '';
          diasRestantesInput.value = '';
        }
      }

      tipoSolicitud.addEventListener('change', actualizarCampos);
      actualizarCampos();
    });

    document.addEventListener('DOMContentLoaded', function () {
      const fechaDesde = document.getElementById('fecha_desde');
      const fechaHasta = document.getElementById('fecha_hasta');
      const numeroDias = document.getElementById('numero_dias');

      function calcularDias() {
        const desde = new Date(fechaDesde.value);
        const hasta = new Date(fechaHasta.value);
        if (!isNaN(desde.getTime()) && !isNaN(hasta.getTime())) {
          if (hasta >= desde) {
            const diffTime = hasta - desde;
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;
            numeroDias.value = diffDays;
          } else {
            alert("La fecha de fin no puede ser anterior a la fecha de inicio.");
            fechaHasta.value = "";
            numeroDias.value = "";
          }
        } else {
          numeroDias.value = '';
        }
      }

      fechaDesde.addEventListener('change', calcularDias);
      fechaHasta.addEventListener('change', calcularDias);
    });

    $(document).ready(function() {
      $('#nombre_completo').select2({
        placeholder: 'Buscar usuario...',
        allowClear: true,
        ajax: {
          url: 'buscar_usuarios.php',
          type: 'POST',
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return { term: params.term || '' };
          },
          processResults: function(data) {
            return {
              results: data.map(function(item) {
                return {
                  id: item.id,
                  text: item.text, // "text" viene desde PHP
                  rut: item.rut
                };
              })
            };
          },
          cache: true
        },
        minimumInputLength: 1
      });

      $('#nombre_completo').on('select2:select', function(e) {
        var data = e.params.data;
        $('input[name="run"]').val(data.rut);
      });

      $('#nombre_completo').on('select2:clear', function() {
        $('input[name="run"]').val('');
      });
    });
  </script>

</body>
</html>
