<?php
// Conexión a la base de datos
include '../conecction.php'; // Asegúrate de que la ruta sea correcta

$id_service = $_POST['id_service'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$id_category = $_POST['id_category'];

$sql = "UPDATE services SET name = ?, description = ?, price = ?, id_category = ? WHERE id_service = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdii", $name, $description, $price, $id_category, $id_service);

if ($stmt->execute()) {
    echo "Servicio actualizado correctamente";
} else {
    echo "Error al actualizar el servicio: " . $conn->error;
}

$stmt->close();
$conn->close();
?>