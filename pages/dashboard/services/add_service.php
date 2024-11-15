<?php
// Conexión a la base de datos
include '../conecction.php';

// Obtener los datos del formulario
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$id_category = $_POST['id_category'];

// Consulta SQL para insertar el nuevo servicio
$sql = "INSERT INTO services (name, description, price, id_category) 
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdi", $name, $description, $price, $id_category);

if ($stmt->execute()) {
    echo "Servicio agregado correctamente";
} else {
    echo "Error al agregar el servicio: " . $conn->error;
}

$stmt->close();
$conn->close();
?>