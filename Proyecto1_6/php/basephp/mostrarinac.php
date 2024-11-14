<?php
require 'conexion.php';

// CONSULTA SQL PARA PODER MOSTRAR LAS PERSONAS INACTIVAS DENTRO DE ARCHIVO.

$query = "SELECT numCedula, nombre, apellido, genero, fecnac, activo FROM persona WHERE persona.activo = 0"; 
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error en la consulta: " . mysqli_error($conn); 
}
?>

