<?php
// get_top_services.php

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

// Consulta para obtener los 10 servicios más solicitados
$sqlTopServices = "
  SELECT 
    s.name AS service_name, 
    COUNT(a.id_service) AS total_requests
  FROM 
    appointments a
  JOIN 
    services s ON a.id_service = s.id_service
  GROUP BY 
    a.id_service
  ORDER BY 
    total_requests DESC
  LIMIT 10
";
$stmt = $conn->prepare($sqlTopServices);
$stmt->execute();
$result = $stmt->get_result();

// Variable para almacenar los datos
$topServices = [];

if ($result->num_rows > 0) {
  // Recuperar todos los resultados y almacenarlos en un array
  while ($row = $result->fetch_assoc()) {
    $topServices[] = $row;
  }
} else {
  // En caso de que no haya resultados, devolver un mensaje de error
  echo json_encode(["error" => "No se encontraron servicios solicitados"]);
  exit();
}

// Cerrar la conexión
$conn->close();

// Devolver el array de servicios más solicitados en formato JSON
echo json_encode($topServices);
