<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Incluye la conexión a la base de datos
include '../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

// Validación de datos recibidos
if (!isset($data['nombre_usuario'], $data['password'], $data['correo_electronico'])) {
    echo json_encode(["error" => "Faltan datos"]);
    exit();
}

$nombre_usuario = $data['nombre_usuario'];
$password = password_hash($data['password'], PASSWORD_DEFAULT); // Hashear la contraseña
$correo_electronico = $data['correo_electronico'];

// Inserta el usuario en la base de datos
$sql = "INSERT INTO usuarios (nombre_usuario, password, correo_electronico) VALUES ('$nombre_usuario', '$password', '$correo_electronico')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Usuario registrado exitosamente"]);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>
