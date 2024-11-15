<?php
// Descomentar estas líneas para depurar
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";  // Asegúrate de que esta contraseña sea correcta para tu base de datos
$dbname = "db_barberia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$sql = "
    SELECT 
        c.id_category, 
        c.name AS category_name, 
        s.id_service, 
        s.name AS service_name, 
        s.description, 
        s.price
    FROM 
        categories AS c
    JOIN 
        services AS s ON c.id_category = s.id_category
    ORDER BY 
        c.name, s.name;
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $category_id = $row['id_category'];
        
        if (!isset($categories[$category_id])) {
            $categories[$category_id] = [
                "id_category" => $row['id_category'],
                "category_name" => $row['category_name'],
                "services" => []
            ];
        }
        
        $categories[$category_id]['services'][] = [
            "id_service" => $row['id_service'],
            "service_name" => $row['service_name'],
            "description" => $row['description'],
            "price" => $row['price']
        ];
    }

    // Convertir a JSON y devolver
    echo json_encode(array_values($categories));  // Asegúrate de que se está enviando como JSON
} else {
    echo json_encode([]);  // Si no hay resultados, devolver un array vacío
}

$conn->close();
?>