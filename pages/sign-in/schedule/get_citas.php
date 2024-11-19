<?php
// Incluye la conexión a la base de datos
include '../conecction.php';

// Consulta SQL
$sql = "SELECT 
            a.id_appointment,
            u.username AS user,
            DATE_FORMAT(a.appointment_datetime, '%Y-%m-%d') AS date,
            DATE_FORMAT(a.appointment_datetime, '%H:%i') AS time,
            s.name AS service
        FROM appointments a
        INNER JOIN users u ON a.id_user = u.id_user
        INNER JOIN services s ON a.id_service = s.id_service
        ORDER BY a.appointment_datetime ASC";

$result = $conn->query($sql);

// Array donde se almacenarán las citas
$appointments = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
} else {
    // Si la consulta falla
    die(json_encode(['error' => 'Error en la consulta SQL: ' . $conn->error]));
}

// Asegúrate de que la respuesta sea JSON
header('Content-Type: application/json');
echo json_encode($appointments);
$conn->close(); // No olvides cerrar la conexión
?>
