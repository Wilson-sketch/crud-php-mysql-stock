<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "pweb_final_db";

// Crear conexión
$conn = mysqli_connect($host, $user, $password, $database);

// Verificar conexión
if (!$conn) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Opcional: establecer charset UTF-8
mysqli_set_charset($conn, "utf8");
?>
