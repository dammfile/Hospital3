<?php
require 'conexion.php';

// BORRDO LÓGICO DONDE COLOCARA "ACTIVO" A 0

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];

    $sqlUpdate = "UPDATE persona SET activo = 0 WHERE numCedula = $cedula";
    if ($conn->query($sqlUpdate) === TRUE) {
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
