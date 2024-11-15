    <?php
    header('Content-Type: application/json');
    //conexion a la base de datos
        include'conexion.php';

        //ejecutar la consulta para obetener las barberia
        function Sucursales($conexion){
            $sql = "SELECT id_barber, service_number FROM barbers";
            $result = mysqli_query($conexion, $sql); //la conexión
        
            if (!$result) {
                echo json_encode(['error' => 'Error en la consulta SQL: ' . mysqli_error($conexion)]);
                exit();
            }
        
            $sucursales = []; // Array para almacenar las sucursales
            while ($row = mysqli_fetch_assoc($result)) {
                $sucursales[] = $row;
            }
        
            echo json_encode($sucursales);
        }
    // Función para obtener los días disponibles
    function dias($conexion, $barber_id){
        $sql = "SELECT service_days FROM barbers WHERE id_barber = ?";
        
        // Preparamos la consulta para evitar inyecciones SQL
        $stmt = mysqli_prepare($conexion, $sql);  
        mysqli_stmt_bind_param($stmt, "i", $barber_id);  // Asociamos el parámetro con el valor de barber_id
        mysqli_stmt_execute($stmt);
        
        $resultados = mysqli_stmt_get_result($stmt); // Obtenemos el resultado
        $barberia = mysqli_fetch_assoc($resultados); // Obtenemos los datos de la barbería

        // Obtenemos los días disponibles de la barbería
        $dias_servicio =  $barberia['service_days'];
        $dias_disponibles = []; // Array para los días disponibles

        // Determinamos los días disponibles según el valor binario de service_days
        for ($i = 1; $i <= 7; $i++) {
            if (($dias_servicio >> ($i - 1)) & 1) {
                // Agregar el nombre del día correspondiente a la lista
                $dias_disponibles[] = date('l', strtotime("Sunday +$i days"));
            }
        }
        // Devolver los días disponibles como JSON
        echo json_encode($dias_disponibles);

    }

    function horas_disp($conexion, $barber_id, $fecha){
        $sql = "SELECT opening_time, closing_time FROM barbers WHERE id_barber = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $barber_id);  // Asociamos el parámetro con el valor de barber_id
        mysqli_stmt_execute($stmt);
        
        $resultados = mysqli_stmt_get_result($stmt); // Obtenemos el resultado
        $barberia = mysqli_fetch_assoc($resultados); // Obtenemos los datos de la barbería

        // Verificamos si la barbería tiene horario de apertura y cierre definidos
        if ($barberia) {
            $hora_apertura = new DateTime($barberia['opening_time']);
            $hora_cierre = new DateTime($barberia['closing_time']);
            $horas_disponibles = [];

            // Generar las horas disponibles entre la apertura y el cierre
            while ($hora_apertura <= $hora_cierre) {
                $horas_disponibles[] = $hora_apertura->format('H:i'); // Agregar la hora disponible
                $hora_apertura->modify('+1 hour');  // Aumentar una hora
            }

            // Devolver las horas disponibles como JSON
            echo json_encode($horas_disponibles);
        } else {
            echo json_encode(['error' => 'No se encontró la barbería.']);
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'get_sucursales':
                    Sucursales($conexion);
                    break;
                case 'get_dias_disponibles':
                    if (isset($_POST['barber_id'])) {
                        $barber_id = $_POST['barber_id'];
                        dias($conexion, $barber_id);
                    }
                    break;
                case 'get_horas_disponibles':
                    if (isset($_POST['barber_id']) && isset($_POST['fecha'])) {
                        $barber_id = $_POST['barber_id'];
                        $fecha = $_POST['fecha'];
                        horas_disp($conexion, $barber_id, $fecha);
                    }
                    break;
                default:
                    echo json_encode(['error' => 'Acción no válida.']);
                    break;
            }
        }
    }
    ?>


 



