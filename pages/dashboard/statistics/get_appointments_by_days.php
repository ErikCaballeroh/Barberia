<?php
// get_appointments_by_day.php

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

// Consulta para obtener el número de citas por día de la semana
$sqlAppointmentsByDay = "
  SELECT 
    DAYNAME(appointment_datetime) AS day_week, 
    COUNT(*) AS total_appointments
  FROM 
    appointments
  GROUP BY 
    day_week
  ORDER BY 
    FIELD(day_week, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')
";

$stmt = $conn->prepare($sqlAppointmentsByDay);
$stmt->execute();
$result = $stmt->get_result();

// Variable para almacenar los datos
$appointmentsByDay = [];

if ($result->num_rows > 0) {
  // Recuperar todos los resultados y almacenarlos en un array
  while ($row = $result->fetch_assoc()) {
    $appointmentsByDay[] = $row;
  }
} else {
  // En caso de que no haya resultados, devolver un mensaje de error
  echo json_encode(["error" => "No se encontraron citas"]);
  exit();
}

// Cerrar la conexión
$conn->close();

// Devolver los datos en formato JSON
echo json_encode($appointmentsByDay);
