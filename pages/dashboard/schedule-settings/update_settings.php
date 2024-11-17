<?php
// update_settings.php

// Iniciar sesión para verificar el rol
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 1 = administrador)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
  echo json_encode(["error" => "No tienes permiso para realizar esta acción."]);
  exit();
}

// Incluir el archivo de conexión
include '../conecction.php';

// Obtener los datos enviados desde AJAX
$data = json_decode(file_get_contents("php://input"), true);

// Validar que los datos necesarios estén presentes
if (
  !isset($data['opening_time']) ||
  !isset($data['closing_time']) ||
  !isset($data['max_clients']) ||
  !isset($data['service_days'])
) {
  echo json_encode(["error" => "Datos incompletos"]);
  exit();
}

// Obtener el ID de la barberia correspondiente al admin
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
  echo json_encode(["error" => "No se encontró el barbero"]);
  exit();
}

// Preparar la consulta de actualización
$sqlUpdate = "UPDATE barbers 
              SET opening_time = ?, closing_time = ?, max_clients = ?, service_days = ? 
              WHERE id_barber = ?";
$stmt = $conn->prepare($sqlUpdate);
$stmt->bind_param(
  "sssii",
  $data['opening_time'],
  $data['closing_time'],
  $data['max_clients'],
  $data['service_days'],
  $barberID
);

// Ejecutar la consulta y verificar el resultado
if ($stmt->execute()) {
  echo json_encode(["success" => "Configuración actualizada con éxito"]);
} else {
  echo json_encode(["error" => "Error al actualizar la configuración"]);
}

// Cerrar la conexión
$stmt->close();
$conn->close();
