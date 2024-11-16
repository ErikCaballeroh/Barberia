<?php
include '../conecction.php'; // Conexión a la base de datos

if (isset($_POST['serviceId'])) {
    $serviceId = intval($_POST['serviceId']);

    // Consulta para eliminar el servicio
    $stmt = $conn->prepare("DELETE FROM services WHERE id_service = ?");
    $stmt->bind_param("i", $serviceId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Servicio eliminado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el servicio: ' . $conn->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID del servicio no proporcionado.']);
}

$conn->close();
?>
