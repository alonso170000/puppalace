<?php
$host = 'localhost'; // Cambiar si es necesario
$user = 'root';      // Cambiar si es necesario
$password = '';      // Cambiar si es necesario
$dbname = 'animals'; // Nombre de tu base de datos

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Consultar los valores únicos para 'sexo', 'tamano' y 'raza' de la base de datos
$sqlSexo = "SELECT DISTINCT sexo FROM mascotas";
$sqlTamano = "SELECT DISTINCT tamano FROM mascotas";
$sqlRaza = "SELECT DISTINCT raza FROM mascotas";

// Ejecutar las consultas
$resultSexo = $conn->query($sqlSexo);
$resultTamano = $conn->query($sqlTamano);
$resultRaza = $conn->query($sqlRaza);

// Guardar los valores
$sexos = [];
$tamanos = [];
$razas = [];

while ($row = $resultSexo->fetch_assoc()) {
    $sexos[] = $row['sexo'];
}

while ($row = $resultTamano->fetch_assoc()) {
    $tamanos[] = $row['tamano'];
}

while ($row = $resultRaza->fetch_assoc()) {
    $razas[] = $row['raza'];
}

$conn->close();

// Devolver los datos como JSON
echo json_encode(['sexos' => $sexos, 'tamanos' => $tamanos, 'razas' => $razas]);
?>
