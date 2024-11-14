<?php
// Datos para ingreso a la base de datos
$host = 'localhost';          
$database = 'dammfile';      
$user = 'root';         
$password = '';  

// definir $conn para crear la conexión mysqli
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión y mostrar error en caso de fallo
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} 
?>

