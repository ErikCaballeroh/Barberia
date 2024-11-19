<?php
// Inicia la sesión para acceder a las variables de sesión
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 2 = cliente)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    // Si no es cliente, redirigir a la página de inicio
    header('Location: /barberia/index.php');
    exit();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    die(json_encode(['error' => 'Usuario no autenticado']));
}

// Obtiene el id del usuario loggeado desde la sesión
$id_user = $_SESSION['id'];

// Conexión a la base de datos
include '../conecction.php';

// Consulta SQL para obtener las citas del usuario loggeado
$sql = "SELECT 
            a.id_appointment,
            u.username AS user,
            DATE_FORMAT(a.appointment_datetime, '%Y-%m-%d') AS date,
            DATE_FORMAT(a.appointment_datetime, '%H:%i') AS time,
            s.name AS service
        FROM appointments a
        INNER JOIN users u ON a.id_user = u.id_user
        INNER JOIN services s ON a.id_service = s.id_service
        WHERE a.id_user = ?
        ORDER BY a.appointment_datetime ASC";

// Prepara la consulta para prevenir inyecciones SQL
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(['error' => 'Error al preparar la consulta: ' . $conn->error]));
}

// Vincula el parámetro
$stmt->bind_param('i', $id_user);

// Ejecuta la consulta
$stmt->execute();
$result = $stmt->get_result();

// Array donde se almacenarán las citas
$appointments = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
} else {
    die(json_encode(['error' => 'Error en la consulta SQL: ' . $stmt->error]));
}

// Asegúrate de que la respuesta sea JSON
header('Content-Type: application/json');
echo json_encode($appointments);

// Cierra la consulta y la conexión
$stmt->close();
$conn->close();
