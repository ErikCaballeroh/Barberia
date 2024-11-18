<?php

include '../conecction.php';

header('Content-Type: application/json');

$idBarber = $_GET['idBarber'] ?? null;
$fecha = $_GET['fecha'] ?? null;

if (!$idBarber || !$fecha) {
    echo json_encode([]);
    exit;
}

// Obtén la hora de apertura, cierre y citas actuales
$query = "SELECT opening_time, closing_time, max_clients 
          FROM db_barberia.barbers WHERE id_barber = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $idBarber);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $openingTime = strtotime($row['opening_time']);
    $closingTime = strtotime($row['closing_time']);
    $maxClients = intval($row['max_clients']);

    // Consulta cuántas citas ya existen
    $queryAppointments = "SELECT appointment_datetime 
                          FROM db_barberia.appointments 
                          WHERE id_barber = ? AND DATE(appointment_datetime) = ?";
    $stmt = $conn->prepare($queryAppointments);
    $stmt->bind_param('is', $idBarber, $fecha);
    $stmt->execute();
    $resultAppointments = $stmt->get_result();

    $occupiedSlots = [];
    while ($appointment = $resultAppointments->fetch_assoc()) {
        $hour = date('H:i', strtotime($appointment['appointment_datetime']));
        $occupiedSlots[$hour] = isset($occupiedSlots[$hour]) ? $occupiedSlots[$hour] + 1 : 1;
    }

    // Generar horarios disponibles
    $availableSlots = [];
    for ($time = $openingTime; $time < $closingTime; $time += 3600) { // Incrementa en 1 hora
        $hour = date('H:i', $time);
        if (!isset($occupiedSlots[$hour]) || $occupiedSlots[$hour] < $maxClients) {
            $availableSlots[] = $hour;
        }
    }

    echo json_encode($availableSlots);
} else {
    echo json_encode([]);
}
?>