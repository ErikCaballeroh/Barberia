<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header('Location: /barberia/index.php');
    exit();
}

include '../conecction.php';

$sql = "SELECT 
            a.id_appointment,
            u.username AS user,
            s.name AS service,
            DATE_FORMAT(a.appointment_datetime, '%Y-%m-%d') AS date,
            DATE_FORMAT(a.appointment_datetime, '%H:%i') AS time
        FROM appointments a
        INNER JOIN users u ON a.id_user = u.id_user
        INNER JOIN services s ON a.id_service = s.id_service
        ORDER BY a.appointment_datetime ASC";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => $conn->error]);
    exit();
}

$appointments = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($appointments);
exit();
?>