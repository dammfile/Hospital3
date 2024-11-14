<?php
include 'validarcedula.php';
require 'conexion.php';

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST["cedula"]; 
    $nombre = $_POST["nombre"]; 
    $apellido = $_POST["apellido"];
    $genero = $_POST["genero"];
    $fecnac = $_POST["fecnac"];
    $activo = "1";
    
    if (empty($cedula) || empty($nombre) || empty($apellido) || empty($genero) || empty($fecnac)) {
        header("Location: ../registropersona.php");
        exit();
    }

    // UTILIZAR LA FUNCION "validarCedula" CON LOS DATOS DATOS DE LA VARIABLE CEDULA VERIFICANDO SI ESTA ES URUGUAYA
    if (!validarCedula($cedula)) {
        header("Location: ../registropersona.php");
        exit();
    }
    // INSERTA UNA NUEVA PERSONA A LA TABLA PERSONA
    $sql = "INSERT INTO persona (numCedula, nombre, apellido, genero, fecnac, activo) VALUES ('$cedula', '$nombre', '$apellido', '$genero', '$fecnac', '$activo')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../personas.php"); 
        exit(); 
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
