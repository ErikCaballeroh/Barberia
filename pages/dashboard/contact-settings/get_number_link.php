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
    // Si no se encuentra el ID del barbero, redirige o muestra un error
    echo json_encode(["error" => "No se encontró el barbero asociado a este usuario"]);
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
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            Swal.fire({
                title: 'Actualizado!',
                text: 'La información se actualizó correctamente.',
                icon: 'success'
            }).then(() => {
                window.location.href = window.location.href;  // Recargar la misma página
            });
          </script>";
    exit();
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Hubo un error al actualizar la información.',
                icon: 'error'
            }).then(() => {
                window.location.href = window.location.href;  // Recargar la misma página
            });
          </script>";
    exit();
}


// Cerrar la conexión
$conn->close();
?>