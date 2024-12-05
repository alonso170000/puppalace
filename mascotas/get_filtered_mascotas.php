<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'animals');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir filtros
$raza = $_GET['raza'] ?? 'todos';
$sexo = $_GET['sexo'] ?? 'todos';
$tamano = $_GET['tamano'] ?? 'todos';

// Construir consulta
$sql = "SELECT nombre, edad, sexo, tamano, imagen_mascota FROM mascotas WHERE 1";

if ($raza !== 'todos') {
    $sql .= " AND raza = '$raza'";
}
if ($sexo !== 'todos') {
    $sql .= " AND sexo = '$sexo'";
}
if ($tamano !== 'todos') {
    $sql .= " AND tamano = '$tamano'";
}

$result = $conn->query($sql);

$mascotas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mascotas[] = [
            'nombre' => $row['nombre'],
            'edad' => $row['edad'],
            'sexo' => $row['sexo'],
            'tamano' => $row['tamano'],
            'imagen_mascota' => base64_encode($row['imagen_mascota']),
        ];
    }
}

echo json_encode($mascotas);

$conn->close();
?>
