<?php
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "db_barberia";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "
    SELECT 
        a.id_appointment, 
        u.username AS user, 
        DATE_FORMAT(a.appointment_datetime, '%d/%m/%Y') AS date,
        TIME_FORMAT(a.appointment_datetime, '%H:%i') AS time,
        s.name AS service
    FROM appointments a
    JOIN users u ON a.id_user = u.id_user
    JOIN services s ON a.id_service = s.id_service
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
    echo json_encode($appointments);
} else {
    echo json_encode([]);
}

$conn->close();
?>