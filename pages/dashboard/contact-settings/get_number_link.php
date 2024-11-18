<?php
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 1 = administrador)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
  // Si no es administrador, redirigir a la página de inicio
  header('Location: /barberia/index.php');
  exit();
}

// Conexión a la base de datos
include '../conecction.php';
// Obtener el id_user desde la sesión
$id_user = $_SESSION['id'];

// Obtener el ID del barbero correspondiente al usuario
$sqlBarber = "SELECT id_barber FROM staff WHERE id_user = ?";
$stmt = $conn->prepare($sqlBarber);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

$barberID = null;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $barberID = $row['id_barber'];
} else {
    // Si no se encuentra el ID del barbero, retornar un error JSON
    echo json_encode(["status" => "error", "message" => "No se encontró el barbero asociado a este usuario"]);
    exit();
}

// Sanear los datos del formulario para evitar SQL Injection
$whatsapp = $_POST['whatsapp'];
$maps = $_POST['maps'];

$whatsapp = $conn->real_escape_string($whatsapp);
$maps = $conn->real_escape_string($maps);

// Actualizar la información de la barbería
$sqlUpdate = "UPDATE barbers SET service_number = ?, googlemaps_link = ? WHERE id_barber = ?";
$stmt = $conn->prepare($sqlUpdate);
$stmt->bind_param("ssi", $whatsapp, $maps, $barberID);

if ($stmt->execute()) {
    // Respuesta exitosa en formato JSON
    echo json_encode(["status" => "success", "message" => "La información se actualizó correctamente."]);
} else {
    // Respuesta de error en formato JSON
    echo json_encode(["status" => "error", "message" => "Hubo un error al actualizar la información."]);
}

// Cerrar la conexión
$conn->close();
?>