<?php
// Conexion a la base de datos
include '../conecction.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanear los datos del formulario para evitar SQL Injection
    $whatsapp = $_POST['whatsapp'];
    $maps = $_POST['maps'];
    $branch_id = $_POST['branch'];  // El ID de la sucursal seleccionada (usando id_barber)

    $whatsapp = $conn->real_escape_string($whatsapp);
    $maps = $conn->real_escape_string($maps);
    $branch_id = $conn->real_escape_string($branch_id);

    // Actualizar el número de WhatsApp y el enlace de Google Maps para la sucursal seleccionada
    $sql = "UPDATE barbers SET service_number = '$whatsapp', googlemaps_link = '$maps' WHERE id_barber = '$branch_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Información actualizada correctamente.</div>";
        
        echo '<script>alert("cambios realizados");
                    window.location = "/barberia/pages/dashboard/dashboard.html";
        </script>';
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar la información: " . $conn->error . "</div>";
    }

    // Cerrar la conexión
    $conn->close();
}
?>