<?php
include 'conexion.php';

header('Content-Type: application/json');

// Consulta para obtener todos los comentarios
$sql = "SELECT nombre, apellido, email, telefono, mensaje FROM comentarios";
$result = $conn->query($sql);

$comments = [];

if ($result->num_rows > 0) {
    // Iterar sobre los resultados y almacenarlos en el array $comments
    while ($row = $result->fetch_assoc()) {
        $comments[] = [
            'nombre' => $row['nombre'],
            'apellido' => $row['apellido'],
            'email' => $row['email'],
            'telefono' => $row['telefono'],
            'mensaje' => $row['mensaje']
        ];
    }
} else {
    $comments = []; // No hay comentarios
}

echo json_encode($comments);

$conn->close();
?>
