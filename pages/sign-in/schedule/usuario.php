<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_barberia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'getSucursales':
        getSucursales();
        break;

    case 'getServices':
        getServices();
        break;

    case 'getAvailability':
        getAvailability();
        break;

    case 'agendarCita':
        agendarCita();
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}

function getSucursales() {
    global $conn; // Usar la variable de conexión correctamente
    $query = "SELECT id_barber, opening_time, closing_time, service_days, max_clients, service_number, googlemaps_link FROM barbers";
    $result = mysqli_query($conn, $query);
    $sucursales = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $sucursales[] = $row;
    }
    echo json_encode($sucursales);
}

function getServices() {
    global $conn;
    $query = "SELECT DISTINCT service_number FROM barbers";
    $result = mysqli_query($conn, $query);
    $services = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $services[] = ['service_number' => $row['service_number']]; // Estructura consistente
    }
    echo json_encode($services);
}

function getAvailability() {
    global $conn;
    
    // Asegúrate de usar $_GET o $_POST según cómo envíes los datos en la solicitud AJAX
    $sucursal_id = isset($_GET['sucursal_id']) ? $_GET['sucursal_id'] : '';
    $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

    if (empty($sucursal_id) || empty($fecha)) {
        echo json_encode(['success' => false, 'message' => 'Datos faltantes']);
        return;
    }

    // Obtener datos de la barbería
    $query = "SELECT opening_time, closing_time, service_days, max_clients FROM barbers WHERE id_barber = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta']);
        return;
    }
    
    $stmt->bind_param('i', $sucursal_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Sucursal no encontrada']);
        return;
    }

    $barber = $result->fetch_assoc();
    $dayOfWeek = date('w', strtotime($fecha)); // Día de la semana en formato 0-6
    $serviceDaysBinary = str_pad(decbin($barber['service_days']), 7, '0', STR_PAD_LEFT);

    if ($serviceDaysBinary[6 - $dayOfWeek] === '0') {
        echo json_encode(['success' => false, 'message' => 'La sucursal no opera ese día']);
        return;
    }

    $horas_disponibles = [];
    $opening = new DateTime($barber['opening_time']);
    $closing = new DateTime($barber['closing_time']);
    $interval = new DateInterval('PT1H');

    for ($hora = $opening; $hora < $closing; $hora->add($interval)) {
        $horas_disponibles[] = $hora->format('H:i:s');
    }

    echo json_encode(['success' => true, 'horas_disponibles' => $horas_disponibles]);
}

function agendarCita() {
    global $conn;
    
    // Asegúrate de que los datos se reciban correctamente, usa $_POST si envías la solicitud con método POST
    $sucursal_id = isset($_POST['sucursal_id']) ? $_POST['sucursal_id'] : '';
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
    $hora = isset($_POST['hora']) ? $_POST['hora'] : '';
    $servicio = isset($_POST['servicio']) ? $_POST['servicio'] : '';

    if (empty($sucursal_id) || empty($fecha) || empty($hora) || empty($servicio)) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos para agendar la cita']);
        return;
    }

    $query = "INSERT INTO appointments (barber_id, date, time, service) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta']);
        return;
    }

    $stmt->bind_param('isss', $sucursal_id, $fecha, $hora, $servicio);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cita agendada exitosamente']);
    } else {
        error_log("Error al agendar cita: " . $stmt->error); // Para ver el error de la base de datos
        echo json_encode(['success' => false, 'message' => 'Error al agendar la cita']);
    }
}
?>