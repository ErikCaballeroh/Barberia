<?php
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 1 = administrador)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    echo json_encode(['success' => false, 'error' => 'Acceso denegado']);
    exit();
}

// Conexión a la base de datos
include '../conecction.php';

// Verifica si el ID del usuario está presente
if (isset($_POST['id_user'])) {
    $id_user = $_POST['id_user'];

    // Asegúrate de que el ID sea un número entero
    $id_user = (int) $id_user;

    // Verificar si la conexión está establecida correctamente
    if ($conn === false) {
        echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']);
        exit;
    }

    // Desactivar las comprobaciones de claves foráneas
    $conn->query("SET foreign_key_checks = 0");

    // Preparar la consulta SQL
    $sql = "DELETE FROM users WHERE id_user = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Vincula el parámetro
        $stmt->bind_param("i", $id_user); // "i" significa entero para el ID del usuario

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
        } else {
            // Capturar y mostrar el error específico de MySQL
            $error = $stmt->error;
            echo json_encode(['success' => false, 'error' => 'Error al ejecutar la consulta: ' . $error]);
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        // Si prepare falla, muestra el error
        echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta SQL: ' . $conn->error]);
    }

    // Habilitar nuevamente las comprobaciones de claves foráneas
    $conn->query("SET foreign_key_checks = 1");

    // Cerrar la conexión
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'ID del usuario no proporcionado']);
}
?>