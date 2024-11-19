<?php
// Iniciar sesión para acceder a las variables de sesión
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 2 = cliente)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    // Si no es cliente, redirigir a la página de inicio
    header('Location: /barberia/index.php');
    exit();
}

// Verificar si se recibe el ID de la barbería y la fecha
if (!isset($_GET['id_barber']) || empty($_GET['id_barber']) || !isset($_GET['date']) || empty($_GET['date'])) {
    echo json_encode(["error" => "ID de barbería o fecha no proporcionados"]);
    exit();
}

$barberId = intval($_GET['id_barber']); // Asegurarse de que sea un entero
$date = $_GET['date']; // Fecha en formato 'Y-m-d'

// Conexión a la base de datos
include '../conecction.php'; // Asegúrate de que esta ruta sea correcta

// Consulta para obtener el número máximo de clientes por hora para esta barbería
$sql_max_clients = "SELECT max_clients FROM barbers WHERE id_barber = ?";
$stmt = $conn->prepare($sql_max_clients);
$stmt->bind_param("i", $barberId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $max_clients = $row['max_clients'];
} else {
    echo json_encode(["error" => "No se encontró la barbería con ID proporcionado"]);
    exit();
}

// Consulta para obtener las horas ocupadas en la fecha dada y barbería
$sql_appointments = "
    SELECT HOUR(appointment_datetime) AS appointment_hour, COUNT(*) AS num_clients
    FROM appointments
    WHERE id_barber = ? AND DATE(appointment_datetime) = ?
    GROUP BY appointment_hour
";
$stmt = $conn->prepare($sql_appointments);
$stmt->bind_param("is", $barberId, $date);
$stmt->execute();
$result = $stmt->get_result();

$occupied_hours = [];
while ($row = $result->fetch_assoc()) {
    $occupied_hours[$row['appointment_hour']] = $row['num_clients'];
}

// Crear un arreglo con las horas llenas en el formato requerido
$full_hours = [];
for ($hour = 0; $hour < 24; $hour++) {
    $clients_at_hour = isset($occupied_hours[$hour]) ? $occupied_hours[$hour] : 0;
    if ($clients_at_hour >= $max_clients) {
        $full_hours[] = [$hour, 0]; // Si la hora está llena, agrega [hora, 0]
    }
}

// Cerrar la conexión
$conn->close();

// Devolver las horas llenas en formato JSON
if (count($full_hours) > 0) {
    echo json_encode($full_hours);
} else {
    echo json_encode(["message" => "No hay horas llenas para esta fecha."]);
}
