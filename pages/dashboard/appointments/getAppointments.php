<?php
include '../conecction.php';

$sql = "SELECT 
            u.username AS user,
            DATE_FORMAT(a.appointment_datetime, '%Y-%m-%d') AS date,
            DATE_FORMAT(a.appointment_datetime, '%H:%i') AS time,
            s.name AS service
        FROM appointments a
        INNER JOIN users u ON a.id_user = u.id_user
        INNER JOIN services s ON a.id_service = s.id_service
        ORDER BY a.appointment_datetime ASC";

$result = $conn->query($sql);

$appointments = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($appointments);
?>