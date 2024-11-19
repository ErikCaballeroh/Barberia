<?php
// Iniciar sesión para acceder a las variables de sesión
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 2 = cliente)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    // Si no es cliente, redirigir a la página de inicio
    header('Location: /barberia/index.php');
    exit();
}

// Verificar si se recibe el ID de la barbería, el servicio, y la fecha y hora
if (
    !isset($_GET['id_barber']) || empty($_GET['id_barber']) ||
    !isset($_GET['id_service']) || empty($_GET['id_service']) ||
    !isset($_GET['appointment_datetime']) || empty($_GET['appointment_datetime'])
) {
    echo json_encode(["error" => "Faltan datos requeridos"]);
    exit();
}

$barberId = intval($_GET['id_barber']); // Asegurarse de que sea un entero
$serviceId = intval($_GET['id_service']); // Asegurarse de que sea un entero
$appointmentDatetime = $_GET['appointment_datetime']; // Fecha y hora en formato 'Y-m-d H:i:s'

// Obtener el ID del usuario desde la sesión
$userId = $_SESSION['id'];

// Conexión a la base de datos
include '../conecction.php'; // Asegúrate de que esta ruta sea correcta

// Validar que la barbería exista
$sql_barber = "SELECT id_barber FROM barbers WHERE id_barber = ?";
$stmt = $conn->prepare($sql_barber);
$stmt->bind_param("i", $barberId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Barbería no encontrada"]);
    exit();
}

// Validar que el servicio exista
$sql_service = "SELECT id_service FROM services WHERE id_service = ?";
$stmt = $conn->prepare($sql_service);
$stmt->bind_param("i", $serviceId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Servicio no encontrado"]);
    exit();
}

// Verificar si la fecha y hora están disponibles
$sql_check_appointment = "
    SELECT COUNT(*) AS num_appointments 
    FROM appointments
    WHERE id_barber = ? AND appointment_datetime = ?
";
$stmt = $conn->prepare($sql_check_appointment);
$stmt->bind_param("is", $barberId, $appointmentDatetime);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['num_appointments'] > 0) {
    echo json_encode(["error" => "La cita ya está ocupada en ese horario"]);
    exit();
}

// Insertar la cita en la base de datos
$sql_insert_appointment = "
    INSERT INTO appointments (id_barber, id_user, id_service, appointment_datetime) 
    VALUES (?, ?, ?, ?)
";
$stmt = $conn->prepare($sql_insert_appointment);
$stmt->bind_param("iiis", $barberId, $userId, $serviceId, $appointmentDatetime);

if ($stmt->execute()) {
    echo json_encode(["success" => "Cita agregada con éxito"]);
} else {
    echo json_encode(["error" => "Hubo un error al agregar la cita"]);
}

// Cerrar la conexión
$conn->close();
