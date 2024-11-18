<?php
// update_user.php

// Iniciar sesión para acceder a las variables de sesión
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 1 = administrador)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
  // Si no es administrador, redirigir a la página de inicio
  echo json_encode(['success' => false, 'error' => 'Acceso denegado']);
  exit();
}

// Conexion a la base de datos
include '../conecction.php';

// Obtener los datos del formulario (con método POST)
$id_user = $_POST['id_user'];
$username = $_POST['username'];
$email = $_POST['email'];

// Validar los datos
if (empty($id_user) || empty($username) || empty($email)) {
    echo json_encode(['success' => false, 'error' => 'Por favor, complete todos los campos']);
    exit();
}

// Consulta para actualizar los datos del usuario
$sql = "UPDATE users SET username = ?, email = ? WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $username, $email, $id_user);

// Comprobar si la consulta fue exitosa
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
} else {
    // Si hubo un error en la consulta, se proporciona el mensaje completo del error
    echo json_encode(['success' => false, 'error' => 'Error al actualizar el usuario: ' . $conn->error]);
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>