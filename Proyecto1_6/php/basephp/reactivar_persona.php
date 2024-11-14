<?php
require 'conexion.php';

// RECUIBE LA CEDULA DE LA PERSONA PARA AL TOCAR EL BOTON ESTE VUELVA A TENER 1 EN SU ATRIBUTO ACTIVO.

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];

    $sqlUpdate = "UPDATE persona SET activo = 1 WHERE numCedula = $cedula";
    if ($conn->query($sqlUpdate) === TRUE) {;
        header("Location: ../personas.php");
        exit();
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
} else {
    echo "No se proporcionó la cédula.";
}

$conn->close();
?>
