<?php

include '../conecction.php';

header('Content-Type: application/json');

$idBarber = $_POST['sucursal'] ?? null;
$fecha = $_POST['fecha'] ?? null;
$hora = $_POST['hora'] ?? null;
$idService = $_POST['servicio'] ?? null;

if (!$idBarber || !$fecha || !$hora || !$idService) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

$appointmentDatetime = $fecha . ' ' . $hora . ':00';

$query = "INSERT INTO db_barberia.appointments (id_barber, id_service, appointment_datetime) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('iis', $idBarber, $idService, $appointmentDatetime);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cita agendada correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'No se pudo agendar la cita.']);
}
?>