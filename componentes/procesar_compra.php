<?php
require_once 'conexion.php'; // Archivo de conexión a la BD
require_once '../vendor/autoload.php'; // Cargar Dompdf

use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    // Sanitizar y recibir datos
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $provincia = trim($_POST['provincia'] ?? '');
    $ciudad = trim($_POST['ciudad'] ?? '');
    $codigopostal = trim($_POST['codigopostal'] ?? '');
    $productos = $_POST['productos'] ?? '[]'; // Los productos vienen como JSON
    $total = floatval($_POST['total'] ?? 0);

    // Validar datos esenciales
    if (!$nombre || !$apellido || !$telefono || !$email || !$direccion || !$provincia || !$ciudad || !$codigopostal || empty($productos) || $total <= 0) {
      throw new Exception("Datos incompletos o incorrectos.");
    }

    // Convertir productos a formato JSON para almacenar en la BD
    $productos_array = json_decode($productos, true); // Decodificamos el JSON
    if (!is_array($productos_array)) {
      throw new Exception("Formato de productos incorrecto.");
    }
    $productos_json = json_encode($productos_array, JSON_UNESCAPED_UNICODE);

    // Insertar la compra en la base de datos
    $stmt = $conexion->prepare("INSERT INTO compras (nombre_cliente, apellido_cliente, telefono_cliente, email_cliente, direccion, provincia, ciudad, codigopostal, productos_json, total, fecha_compra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssssssd", $nombre, $apellido, $telefono, $email, $direccion, $provincia, $ciudad, $codigopostal, $productos_json, $total);
    $stmt->execute();

    if ($stmt->error) {
      echo "Error en la consulta: " . $stmt->error;
    }

    if ($stmt->affected_rows <= 0) {
      throw new Exception("Error al registrar la compra.");
    }

    // Obtener ID de la compra generada
    $compra_id = $stmt->insert_id;

    // Crear la carpeta "facturas/" si no existe
    $facturas_dir = __DIR__ . '/../facturas/';
    if (!is_dir($facturas_dir)) {
      mkdir($facturas_dir, 0777, true);
    }

    // Generar factura PDF con Dompdf
    $factura_html = "<h1>Factura #{$compra_id}</h1>
                         <p><strong>Cliente:</strong> {$nombre} {$apellido}</p>
                         <p><strong>Teléfono:</strong> {$telefono}</p>
                         <p><strong>Email:</strong> {$email}</p>
                         <p><strong>Dirección:</strong> {$direccion}, {$ciudad}, {$provincia}, {$codigopostal}</p>
                         <h2>Productos</h2>
                         <ul>";

    // Verificar que los productos sean un array
    if (is_array($productos_array) && count($productos_array) > 0) {
      foreach ($productos_array as $producto) {
        // Asegúrate de que cada producto tenga las claves correctas
        $nombre_producto = $producto['name'] ?? 'Desconocido';
        $cantidad = $producto['cantidad'] ?? 0;
        $precio = $producto['price'] ?? 0;
        $factura_html .= "<li>{$nombre_producto} - {$cantidad} x \${$precio}</li>";
      }
    } else {
      $factura_html .= "<li>No hay productos en la compra.</li>";
    }

    $factura_html .= "</ul><h2>Total: \${$total}</h2>";

    // Configuración de Dompdf
    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($factura_html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Guardar el PDF en la carpeta "facturas/"
    $factura_file = "{$facturas_dir}factura_{$compra_id}.pdf";
    file_put_contents($factura_file, $dompdf->output());

    echo json_encode(["success" => true, "message" => "Compra registrada y factura generada.", "factura" => $factura_file]);
  } catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
  }
} else {
  echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
