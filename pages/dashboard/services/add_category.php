<?php
include '../conecction.php'; // Asegúrate de tener la conexión configurada

// Verificar que los datos necesarios hayan sido enviados
if (isset($_POST['categoryName'])) {
    $category_name = trim($_POST['categoryName']); // Nombre de la categoría

    // Validar que no esté vacío
    if (empty($category_name)) {
        echo json_encode(['success' => false, 'message' => 'El nombre de la categoría no puede estar vacío.']);
        exit;
    }

    // Insertar la categoría en la base de datos
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $category_name); // s = string

    if ($stmt->execute()) {
        // Enviar respuesta con el ID de la nueva categoría
        echo json_encode([
            'success' => true,
            'message' => 'Categoría agregada correctamente.',
            'category_id' => $stmt->insert_id, // ID generado automáticamente
            'category_name' => $category_name
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar la categoría: ' . $conn->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos.']);
}

$conn->close();
?>