<?php
include '../conecction.php';

header('Content-Type: application/json');

$query = "SELECT id_service, name FROM db_barberia.services";
$result = mysqli_query($conn, $query);

$services = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
    }
}

echo json_encode($services);
?>