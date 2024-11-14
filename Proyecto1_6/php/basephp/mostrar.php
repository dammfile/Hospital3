<?php
require 'conexion.php';

// CONSULTA SQL PARA MOSTRAR LAS PERSONAS ACTIVAS

$query = "SELECT numCedula, nombre, apellido, genero, fecnac, activo FROM persona WHERE persona.activo = 1"; 
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error en la consulta: " . mysqli_error($conn); 
}
?>

