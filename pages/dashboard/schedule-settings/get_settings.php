<?php
// get_settings.php

// Iniciar sesión para acceder a las variables de sesión
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 1 = administrador)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
  // Si no es administrador, redirigir a la página de inicio
  header('Location: /barberia/index.php');
  exit();
}

// Conexión a la base de datos
include '../conecction.php';

// Obtener el ID del barbero correspondiente al usuario
$sqlBarber = "SELECT id_barber FROM staff WHERE id_user = ?";
$stmt = $conn->prepare($sqlBarber);
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

$barberID = null;
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $barberID = $row['id_barber'];
} else {
  // Si no se encuentra el ID del barbero, redirige o muestra un error
  echo json_encode(["error" => "No se encontró el barbero"]);
  exit();
}

// Consulta para obtener la configuración de la barbería según el ID del barbero
$sqlSettings = "SELECT opening_time, closing_time, service_days, max_clients FROM barbers WHERE id_barber = ?";
$stmt = $conn->prepare($sqlSettings);
$stmt->bind_param("i", $barberID);
$stmt->execute();
$result = $stmt->get_result();

// Variable para almacenar los datos
$settings = null;

if ($result->num_rows > 0) {
  // Obtener solo la primera fila como objeto
  $settings = $result->fetch_assoc();
} else {
  // En caso de que no haya configuraciones, enviar un mensaje de error
  echo json_encode(["error" => "No se encontraron configuraciones"]);
  exit();
}

// Cerrar la conexión
$conn->close();

// Devolver el objeto en formato JSON
echo json_encode($settings);
