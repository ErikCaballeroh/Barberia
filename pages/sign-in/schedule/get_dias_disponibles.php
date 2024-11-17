<?php
header('Content-Type: application/json');
include '../conecction.php';

$idBarber = $_GET['idBarber'] ?? null;

if (!$idBarber) {
    echo json_encode([]);
    exit;
}

// Consultar los días disponibles en formato binario para el barbero
$query = "SELECT available_days FROM db_barberia.barbers WHERE id_barber = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $idBarber);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Obtener el valor binario
    $availableDaysBinary = $row['available_days'];

    // Definir los días de la semana (de 0 a 6: lunes a domingo)
    $diasDeLaSemana = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    // Descomponer el número binario en los días habilitados
    $diasDisponibles = [];
    for ($i = 0; $i < 7; $i++) {
        // Si el bit correspondiente está activado (1), agregamos el día al array
        if ($availableDaysBinary & (1 << $i)) {
            $diasDisponibles[] = $diasDeLaSemana[$i];
        }
    }

    // Devolver los días habilitados en formato JSON
    echo json_encode($diasDisponibles);
} else {
    // Si no se encuentra el barbero o no tiene días disponibles
    echo json_encode([]);
}
?>