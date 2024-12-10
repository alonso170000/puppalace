<?php
// db_functions.php

// Conexión a la base de datos
function connectDB() {
    $servername = getenv("MYSQLHOST");
    $username = getenv("MYSQLUSER");
    $password = getenv("MYSQLPASSWORD");
    $dbname = getenv("MYSQLDATABASE");
    $port = getenv("MYSQLPORT") ?: 3306;
    
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    
    // Verificar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// Función para agregar mascota
function addMascota($nombre, $edad, $sexo, $raza, $tamano, $estado, $imagen) {
    $conn = connectDB();
    
    $sql = "INSERT INTO mascotas (nombre, edad, sexo, raza, tamaño, imagen_mascota, estado) 
            VALUES ('$nombre', $edad, '$sexo', '$raza', '$tamano', ? , '$estado')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("b", $imagen); // Bind la imagen como binario
    $stmt->execute();
    
    $stmt->close();
    $conn->close();
}

// Función para agregar admin
function addAdmin($nombre_admin, $correo_electronico, $password_hash) {
    $conn = connectDB(); // Ahora llamamos a la función correcta para establecer la conexión
    
    $sql = "INSERT INTO admins (nombre_admin, correo_electronico, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre_admin, $correo_electronico, $password_hash);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close(); // Cierra la conexión aquí para asegurar que todo esté bien
        return true;  // Devuelve true si la inserción fue exitosa
    } else {
        $stmt->close();
        $conn->close(); // Asegúrate de cerrar la conexión también si hubo un error
        return false; // Devuelve false en caso de error
    }
}

?>
