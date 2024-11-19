<?php
// Incluye la conexión a la base de datos
include '../conecction.php';

// Obtener el ID de la cita
$id_appointment = $_POST['id_appointment'];

// Consulta SQL para eliminar la cita
$sql = "DELETE FROM appointments WHERE id_appointment = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_appointment);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cita eliminada correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar la cita: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>
