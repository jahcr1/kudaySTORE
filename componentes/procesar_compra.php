<?php
// Incluir archivo de conexión a la base de datos
require_once 'conexion.php'; // Incluimos el archivo conexion.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    // Recibir los datos desde JavaScript (POST)
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']); //  Nuevo campo
    $telefono = trim($_POST['telefono']); //  Nuevo campo
    $email = trim($_POST['email']);
    $direccion = trim($_POST['direccion']);
    $provincia = trim($_POST['provincia']);
    $ciudad = trim($_POST['ciudad']); //  Nuevo campo
    $codigopostal = trim($_POST['codigopostal']); //  Nuevo campo
    $productos = $_POST['productos']; // JSON con los productos
    $total = floatval($_POST['total']);

    // Validar datos esenciales
    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($email) || empty($direccion) || empty($ciudad) || empty($provincia) || empty($codigopostal) || empty($productos) || $total <= 0) {
      throw new Exception("Datos incompletos o incorrectos.");
    }

    // Convertir productos a formato JSON para guardar en la BD
    $productos_json = json_encode(json_decode($productos, true), JSON_UNESCAPED_UNICODE);

    // Insertar la compra en la base de datos con los nuevos campos
    $stmt = $conexion->prepare("INSERT INTO compras (nombre_cliente, apellido_cliente, telefono_cliente, email_cliente, direccion, provincia, ciudad, codigopostal, productos_json, total, fecha_compra) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssssssd", $nombre, $apellido, $telefono, $email, $direccion, $provincia, $ciudad, $codigopostal, $productos_json, $total);

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar que la inserción fue exitosa
    if ($stmt->affected_rows > 0) {
      echo json_encode(["success" => true, "message" => "Compra registrada exitosamente."]);
    } else {
      throw new Exception("Error al registrar la compra.");
    }
  } catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
  }
} else {
  echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
