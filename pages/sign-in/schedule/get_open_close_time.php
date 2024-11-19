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

// Verificar si se recibe el ID de la barbería
if (!isset($_GET['id_barber']) || empty($_GET['id_barber'])) {
    echo json_encode(["error" => "ID de barbería no proporcionado"]);
    exit();
}

$barberId = intval($_GET['id_barber']); // Asegurarse de que sea un entero

// Conexión a la base de datos
include '../conecction.php'; // Asegúrate de que esta ruta sea correcta

// Consulta para obtener la hora de apertura y cierre de una barbería específica
$sql = "
    SELECT 
        HOUR(opening_time) AS opening_hour, 
        HOUR(closing_time) AS closing_hour 
    FROM barbers
    WHERE id_barber = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $barberId); // Asociar el ID de la barbería como parámetro

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Obtener el primer registro como un objeto
    $openingClosingHours = $result->fetch_assoc();
} else {
    // En caso de que no haya resultados, devolver un mensaje de error
    echo json_encode(["error" => "No se encontraron registros para la barbería con ID proporcionado"]);
    exit();
}

// Cerrar la conexión
$conn->close();

// Devolver los horarios en formato JSON como un objeto
echo json_encode($openingClosingHours);
