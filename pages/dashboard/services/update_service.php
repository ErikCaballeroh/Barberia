<?php
include '../conecction.php'; // Asegúrate de que la conexión a la base de datos esté correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanear los datos recibidos
    $id = intval($_POST['serviceId']); // ID del servicio (aseguramos que sea un número)
    $name = $_POST['serviceName'];
    $description = $_POST['serviceDescription'];
    $price = floatval($_POST['servicePrice']); // Aseguramos que sea un número decimal
    $category = intval($_POST['serviceCategory']); // Aseguramos que sea un número

    // Usar la conexión que ya está definida en conecction.php
    if ($conn) {
        // Preparar la consulta SQL usando sentencias preparadas
        $stmt = $conn->prepare("UPDATE services SET name=?, description=?, price=?, id_category=? WHERE id_service=?");
        
        if ($stmt) {
            // Vincular los parámetros a la consulta preparada
            $stmt->bind_param("ssdii", $name, $description, $price, $category, $id);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Servicio actualizado correctamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el servicio: ' . $stmt->error]);
            }

            // Cerrar la sentencia
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error de conexión con la base de datos.']);
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido.']);
}
?>