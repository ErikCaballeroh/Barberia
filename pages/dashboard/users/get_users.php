<?php
// get_users.php

// Iniciar sesión para acceder a las variables de sesión
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 1 = administrador)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
  // Si no es administrador, redirigir a la página de inicio
  header('Location: /barberia/index.php');
  exit();
}

// Conexion a la base de datos
include '../conecction.php';

// Consulta para obtener los usuarios con id_role = 2
$sql = "SELECT username, password, email FROM users WHERE id_role = 2";
$result = $conn->query($sql);

// Arreglo para almacenar los datos
$users = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $users[] = $row;
  }
}

// Cerrar conexión
$conn->close();

// Devolver los datos en formato JSON
echo json_encode($users);
