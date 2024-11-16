<?php
include '../conecction.php'; // Asegúrate de que la conexión esté configurada correctamente

// Verificar que los datos necesarios hayan sido enviados
if (isset($_POST['serviceName'], $_POST['serviceDescription'], $_POST['servicePrice'], $_POST['serviceCategory'])) {
    $name = $_POST['serviceName']; // Nombre del servicio
    $description = $_POST['serviceDescription']; // Descripción
    $price = $_POST['servicePrice']; // Precio
    $category_id = $_POST['serviceCategory']; // ID de la categoría

    // Validar que no haya campos vacíos
    if (empty($name) || empty($description) || empty($price) || empty($category_id)) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
        exit;
    }

    // Preparar la consulta para insertar el servicio
    $stmt = $conn->prepare("INSERT INTO services (id_category, name, description, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issd", $category_id, $name, $description, $price); // i = entero, s = string, d = decimal

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Servicio agregado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el servicio: ' . $conn->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
}

$conn->close();
?>