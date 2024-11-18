<?php
// get_opening_closing_hour.php

// Iniciar sesión para acceder a las variables de sesión
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 2 = cliente)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    // Si no es cliente, redirigir a la página de inicio
    header('Location: /barberia/index.php');
    exit();
}

// Conexión a la base de datos
include '../conecction.php'; // Asegúrate de que esta ruta sea correcta

// Consulta para obtener solo la hora de apertura y cierre como números enteros
$sql = "
    SELECT 
        HOUR(opening_time) AS opening_hour, 
        HOUR(closing_time) AS closing_hour 
    FROM barbers
";
$stmt = $conn->prepare($sql);

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Obtener el primer registro como un objeto
    $openingClosingHours = $result->fetch_assoc();
} else {
    // En caso de que no haya resultados, devolver un mensaje de error
    echo json_encode(["error" => "No se encontraron registros en la tabla barbers"]);
    exit();
}

// Cerrar la conexión
$conn->close();

// Devolver los horarios en formato JSON como un objeto
echo json_encode($openingClosingHours);
