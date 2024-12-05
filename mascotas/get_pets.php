<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "animals";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verifica si se ha pasado un 'mascota_id' en la URL para obtener detalles de una mascota específica
if (isset($_GET['mascota_id'])) {
    $mascota_id = $_GET['mascota_id'];
    $sql = "SELECT mascota_id, nombre, edad, sexo, raza, tamano, estado FROM mascotas WHERE mascota_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mascota_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $mascota = $result->fetch_assoc();
        echo json_encode($mascota);  // Retorna los detalles de la mascota
    } else {
        echo json_encode([]);  // Si no se encuentra la mascota, retorna un array vacío
    }

    $stmt->close();
} else {
    // Si no se pasa un 'mascota_id', retorna la lista de todas las mascotas
    $sql = "SELECT mascota_id, nombre, edad, sexo, raza, tamano, estado FROM mascotas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $mascotas = [];
        while ($row = $result->fetch_assoc()) {
            $mascotas[] = $row;
        }
        echo json_encode($mascotas);  // Retorna todas las mascotas
    } else {
        echo json_encode([]);  // Si no hay mascotas, retorna un array vacío
    }
}

$conn->close();
?>
