<?php
// get_service_days.php

// Iniciar sesión para acceder a las variables de sesión
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 2 = cliente)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    // Si no es cliente, redirigir a la página de inicio
    header('Location: /barberia/index.php');
    exit();
}

// Verificar si se recibe el ID de la barbería
if (!isset($_GET['barber_id']) || empty($_GET['barber_id'])) {
    echo json_encode(["error" => "ID de barbería no proporcionado"]);
    exit();
}

$barberId = intval($_GET['barber_id']); // Asegurarse de que sea un entero

// Conexión a la base de datos
include '../conecction.php';

// Consulta para obtener el campo service_days de la barbería específica
$sqlServiceDays = "SELECT service_days FROM barbers WHERE id = ?";
$stmt = $conn->prepare($sqlServiceDays);
$stmt->bind_param("i", $barberId); // Asociar el ID de la barbería como parámetro
$stmt->execute();
$result = $stmt->get_result();

// Variable para almacenar los resultados procesados
$serviceDaysArray = [];

if ($result->num_rows > 0) {
    // Recuperar el resultado y procesarlo
    $row = $result->fetch_assoc();
    // Convertir el número base 10 a binario de 7 bits y dividirlo en un arreglo
    $binaryString = str_pad(decbin($row['service_days']), 7, '0', STR_PAD_LEFT);
    $binaryArray = str_split($binaryString);
    // Agregar el arreglo al resultado
    $serviceDaysArray = $binaryArray;
} else {
    // En caso de que no haya resultados, devolver un mensaje de error
    echo json_encode(["error" => "No se encontró la barbería con el ID proporcionado"]);
    exit();
}

// Cerrar la conexión
$conn->close();

// Devolver el array de días de servicio en formato JSON
echo json_encode($serviceDaysArray);
