<?php
require 'conexion.php';
// RECOPILA LOS DATOS A SER EDITADOS Y LOS COLOCA EN VARIABLES
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_form = $_POST["id_form"];
    $cedula = $_POST["cedula"];
    $motivo = $_POST["motivo"];
    $origen = $_POST["origen"]; 
    $localidado = $_POST["localidado"]; 
    $destino = $_POST["destino"];
    $localidadd = $_POST["localidadd"]; 
    $anotaciones = $_POST["anot"];
    $fecviaje = $_POST["fecha"];
    $agencia = $_POST["agencia"];
    $fecha_edicion = date('Y-m-d H:i:s');

    // SENTENCIAS PARA PODER ACTUALIZAR LOS DATOS 

    // ACTUALIZAR LOS DATOS DE LA TABLA PASAJE
    $sql_pasaje = "UPDATE pasaje 
    SET origen='$origen', localidado='$localidado', destino='$destino', localidadd='$localidadd', fecha='$fecviaje'
    WHERE formulario_id_form = '$id_form'";

    if ($conn->query($sql_pasaje) !== TRUE) {
        echo "Error al actualizar en Pasaje: " . $conn->error;
        exit();
    }

    // ACTUALIZAR LOS DATOS DE LA TABLA FORMULARIO.

    $sql_formulario = "UPDATE formulario 
                       SET motivo = '$motivo', anotaciones = '$anotaciones', agencia = '$agencia', ultimaEdicion='$fecha_edicion' 
                       WHERE id_form = '$id_form'";

    if ($conn->query($sql_formulario) !== TRUE) {
        echo "Error al actualizar en formulario: " . $conn->error;
        exit();
    }
// REDIRECCIÓN A LA TABLA DE REGISTROS SI TODO CONCLUYO
    header("Location: ../registros.php");
    exit(); 
}

$conn->close();
